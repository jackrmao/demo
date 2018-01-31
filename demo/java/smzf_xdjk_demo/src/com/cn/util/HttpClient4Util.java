package com.cn.util;

import java.io.IOException;
import java.security.KeyManagementException;
import java.security.NoSuchAlgorithmException;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;
import java.util.List;
import java.util.concurrent.TimeUnit;

import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

import org.apache.http.HeaderElement;
import org.apache.http.HeaderElementIterator;
import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.config.RequestConfig;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.utils.URIBuilder;
import org.apache.http.config.Registry;
import org.apache.http.config.RegistryBuilder;
import org.apache.http.conn.ConnectionKeepAliveStrategy;
import org.apache.http.conn.socket.ConnectionSocketFactory;
import org.apache.http.conn.socket.LayeredConnectionSocketFactory;
import org.apache.http.conn.socket.PlainConnectionSocketFactory;
import org.apache.http.conn.ssl.SSLConnectionSocketFactory;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClientBuilder;
import org.apache.http.impl.conn.PoolingHttpClientConnectionManager;
import org.apache.http.message.BasicHeaderElementIterator;
import org.apache.http.protocol.HTTP;
import org.apache.http.protocol.HttpContext;
import org.apache.http.util.EntityUtils;

public class HttpClient4Util {
	private CloseableHttpClient httpclient;
	private RequestConfig requestConfig;
	private PoolingHttpClientConnectionManager connManager;
	private static HttpClient4Util httpClient4UtilNew;
	private volatile boolean shutdown;
	public synchronized static HttpClient4Util getInstance()
			throws Exception {
		if (httpClient4UtilNew == null) {
			httpClient4UtilNew = new HttpClient4Util();
			httpClient4UtilNew.init();
		}
		return httpClient4UtilNew;
	}
	private HttpClient4Util(){
		
	}
	/**
	 * ���캯��
	 * 
	 * @throws NoSuchAlgorithmException
	 * @throws KeyManagementException
	 */
	public void init() throws NoSuchAlgorithmException, KeyManagementException {
		SSLContext sslCtx = SSLContext.getInstance("TLS");
		X509TrustManager trustManager = new X509TrustManager() {
			public X509Certificate[] getAcceptedIssuers() {
				return null;
			}

			public void checkClientTrusted(X509Certificate[] arg0, String arg1)
					throws CertificateException {
			}

			public void checkServerTrusted(X509Certificate[] arg0, String arg1)
					throws CertificateException {
			}
		};
		sslCtx.init(null, new TrustManager[] { trustManager }, null);
		LayeredConnectionSocketFactory sslSocketFactory = new SSLConnectionSocketFactory(sslCtx, SSLConnectionSocketFactory.ALLOW_ALL_HOSTNAME_VERIFIER);
		RegistryBuilder<ConnectionSocketFactory> registryBuilder = RegistryBuilder
				.<ConnectionSocketFactory> create();
		ConnectionSocketFactory plainSocketFactory = new PlainConnectionSocketFactory();
		registryBuilder.register("http", plainSocketFactory);
		registryBuilder.register("https", sslSocketFactory);

		Registry<ConnectionSocketFactory> registry = registryBuilder.build();
		// �������ӹ�����
		connManager = new PoolingHttpClientConnectionManager(registry);
		// �������������
		connManager.setMaxTotal(200);
		// ����ÿ��·�ɻ���������
		connManager.setDefaultMaxPerRoute(20);

		// ���ӱ��ֻ�Ծ����
		ConnectionKeepAliveStrategy myStrategy = new ConnectionKeepAliveStrategy() {
			//@Override
			public long getKeepAliveDuration(HttpResponse response,
					HttpContext context) {
				// ��ȡ'keep-alive'HTTP����ͷ
				HeaderElementIterator it = new BasicHeaderElementIterator(
						response.headerIterator(HTTP.CONN_KEEP_ALIVE));
				while (it.hasNext()) {
					HeaderElement he = it.nextElement();
					String param = he.getName();
					String value = he.getValue();
					if (value != null && param.equalsIgnoreCase("timeout")) {
						try {
							return Long.parseLong(value) * 1000;
						} catch (NumberFormatException ignore) {
						}
					}
				}
				// ����20���Ծ
				return 20 * 1000;
			}
		};

		httpclient = HttpClientBuilder.create().setConnectionManager(
				connManager).setKeepAliveStrategy(myStrategy).build();

		requestConfig = RequestConfig.custom()
				.setConnectTimeout(5000).setSocketTimeout(
						20000).build();
		shutdown = false;

		new Thread(new Runnable() {
			//@Override
			public void run() {
				while (!shutdown) {
					try {
						synchronized (this) {
							wait(500);
							// �رչ��ڵ�����
							connManager.closeExpiredConnections();
							// �رճ���65��Ŀ�������
							connManager.closeIdleConnections(40,
									TimeUnit.SECONDS);
						}
					} catch (Exception e) {
					}
				}
			}
		}).start();
	}

	/**
	 * ������Get����
	 * 
	 * @param url
	 *            ����URL
	 * @param nameValuePairs
	 *            ����List<NameValuePair>��ѯ����
	 * @return
	 */
	
	public byte[] doGet(String url, List<NameValuePair> nameValuePairs) throws Exception{
		CloseableHttpResponse response = null;
		HttpGet httpget = new HttpGet();
		try {
			URIBuilder builder = new URIBuilder(url);
			// �����ѯ����
			if (nameValuePairs != null && !nameValuePairs.isEmpty()) {
				builder.setParameters(nameValuePairs);
			}
			httpget.setURI(builder.build());
			httpget.setConfig(requestConfig);
			response = httpclient.execute(httpget);
			HttpEntity entity = response.getEntity();
			if (entity != null) {
				return EntityUtils.toByteArray(entity);
			}
		} catch (Exception e) {
			throw e;
		} finally {
			if (response != null) {
				try {
					response.close();
				} catch (IOException e) {
					throw e;
				}
			}
		}
		return null;
	}

	/**
	 * 
	 * @param url
	 * @param queryParams
	 * @param formParams
	 * @return
	 */
	public byte[] doPost(String url, List<NameValuePair> queryParams,
			List<NameValuePair> formParams) throws Exception {
		if(CommonUtil.isnull(url)){
			return null;
		}
		CloseableHttpResponse response = null;
		HttpPost httppost = new HttpPost();
		try {
			URIBuilder builder = new URIBuilder(url);
			// �����ѯ����
			if (queryParams != null && !queryParams.isEmpty()) {
				builder.setParameters(queryParams);
			}
			httppost.setURI(builder.build());
			httppost.setConfig(requestConfig);

			if (formParams != null && !formParams.isEmpty()) {
				httppost.setEntity(new UrlEncodedFormEntity(formParams, "utf-8"));
			}
			response = httpclient.execute(httppost);
			HttpEntity entity = response.getEntity();
			int stateCode= response.getStatusLine().getStatusCode();
			if(200!=stateCode){
				return null;
			}
			if (entity != null) {
				return EntityUtils.toByteArray(entity);
			}
		} catch (Exception e) {
			throw e;
		} finally {
			httppost.releaseConnection();
			if (response != null) {
				try {
					response.close();
				} catch (IOException e) {
					throw e;
				}
			}
		}
		return null;
	}

	public void shutdown() throws IOException {
		shutdown = true;
		connManager.shutdown();
		httpclient.close();
		synchronized (this) {
			notifyAll();
		}
	}
}