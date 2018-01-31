package com.cn.controller;

import java.security.PrivateKey;
import java.security.PublicKey;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.Set;
import java.util.SortedMap;
import java.util.TreeMap;

import javax.servlet.http.HttpServletResponse;

import net.sf.json.JSONObject;

import org.apache.commons.codec.binary.Base64;
import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.ui.ModelMap;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;

import com.cn.model.MercModel;
import com.cn.util.EncodeChanger;
import com.cn.util.GetProperty;
import com.cn.util.HttpClient4Util;
import com.cn.util.httpUtils;
import com.cn.util.PublicUtil;
import com.cn.util.RSAPemCoder;



@Controller
@RequestMapping("ScanCodePay/")
public class ScanCodePayController {
	public static final String privatePath =GetProperty.privatePath;//商户的私钥
	public static final String publicPath = GetProperty.publicPath;//现代金控的公钥
	public static final String filepath = GetProperty.filepath;//现代金控的公钥
	
	@RequestMapping("create")
	public String signMercInformation(MercModel model,ModelMap map){
		SortedMap<String, Object> sortedMap = new TreeMap<String, Object>();
		sortedMap.put("version", model.getVersion());
		sortedMap.put("msgType", model.getMsgType());
		sortedMap.put("merchantId", model.getMerchantId());
		sortedMap.put("orderId", model.getOrderId());
		sortedMap.put("orderTime", model.getOrderTime());
		sortedMap.put("totalAmount", model.getTotalAmount());
		sortedMap.put("productName", model.getProductName());
		sortedMap.put("productDesc", model.getProductDesc());
		sortedMap.put("callBack", model.getCallBack());
		sortedMap.put("signType", model.getSignType());
		sortedMap.put("terminalIp", model.getTerminalIp());
		sortedMap.put("payWay", model.getPayWay());
		System.out.println("payWay======="+model.getPayWay());
		
		Set<String> keySet = sortedMap.keySet();
		for(Iterator<String> iterator = keySet.iterator();iterator.hasNext();){
			String key = iterator.next();
			String value = (String) sortedMap.get(key);
			System.out.println(key + "=" + value);
        }
		String signText = PublicUtil.mapToStringAndTrim(sortedMap);
		System.out.println("参数为="+signText);
		System.out.println(sortedMap);
		sortedMap.put("attach", model.getAttach());
		sortedMap.put("serverUrl", model.getServerUrl());
		map.put("date", sortedMap);
		
		return "ScanCodePaySubmit";
	}
	
	@RequestMapping("submit")
	public String submitMercInformation(MercModel model,ModelMap map,HttpServletResponse resp,Model mode){
		
		SortedMap<String, Object> head = new TreeMap<String, Object>();
		SortedMap<String, Object> body = new TreeMap<String, Object>();
		Map<String,Object> getRespMessage = new HashMap<String,Object>();
		head.put("version", model.getVersion());//版本号
		head.put("msgType", model.getPayWay());//支付方式 01 支付宝 02 微信
		head.put("reqDate",httpUtils.getTime("yyyyMMddHHmmss"));//支付时间
		StringBuffer buffer = new StringBuffer();
		buffer.append("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
				+ "<merchant><head>");
		String headXml = PublicUtil.mapToXmlString(head);
		buffer.append(headXml+"</head>"
				+ "<body>");
		body.put("totalAmount", model.getTotalAmount());//订单金额 元为单位
		body.put("subject", model.getProductName());//订单标题	
		body.put("desc", model.getProductDesc());//订单描述
		body.put("notifyUrl",model.getCallBack());//回调地址

		String bodyXml= PublicUtil.mapToXmlString(body);
		buffer.append(bodyXml+"</body>"
				+ "</merchant>");
		String xml = buffer.toString();
		String en_xml="";




		try {
			en_xml = new String(Base64.encodeBase64(xml.getBytes()));
			System.out.println("加密后的en_xml="+en_xml);
			
			System.out.println("解密后的en_xml="+new String(Base64.decodeBase64(en_xml.getBytes())).toString());
		} catch (Exception e1) {
			e1.printStackTrace();
		}


		String privatepath =privatePath;//商户私钥
		String publicpath =publicPath;//现代金控公钥
		String signData="";
		try {
			PrivateKey  priKey=	RSAPemCoder.getPrivateKeyFromPem(privatepath);
			signData = RSAPemCoder.sign(xml.getBytes("utf-8"), priKey);
		} catch (Exception e) {
			e.printStackTrace();
		}
		List<NameValuePair> nvps =  new ArrayList<NameValuePair>();
		String url=model.getServerUrl();//请求地址 测试环境：生产环境：
		nvps.add(new BasicNameValuePair("xmlData", en_xml));//xml报文
		nvps.add(new BasicNameValuePair("tranCode","SMZF002"));//交易码
		nvps.add(new BasicNameValuePair("reqOrdId", model.getOrderId()));//订单号
		nvps.add(new BasicNameValuePair("signData", signData));//签名
		nvps.add(new BasicNameValuePair("merchantId", model.getMerchantId()));//商户号

		String respXml=null;
		byte[] mString = null;
		try {
				mString = HttpClient4Util.getInstance().doPost(url, null, nvps);
				System.out.println("****************"+mString);
				respXml = new String(mString, "utf-8");
				System.out.println("返回信息11="+respXml );
				JSONObject jsonObject = JSONObject.fromObject(respXml);
				String resEncryptData = jsonObject.getString("encryptData");
				respXml = new String(Base64.decodeBase64(resEncryptData), "utf-8");
				System.out.println("返回信息xml="+respXml);
				String sign = jsonObject.getString("sign");
				System.out.println("返回的签名值为="+sign);
				//验签
				PublicKey  pubKey=	RSAPemCoder.getPublicKey(publicpath,"PEM");
				System.out.println("======PublicKey路径："+pubKey.getAlgorithm());
				if(RSAPemCoder.checksign(pubKey, respXml, sign, "SHA1WithRSA")){
					System.out.println("签名通过");
					getRespMessage=PublicUtil.xmlToMap(respXml);
					String qrcode=getRespMessage.get("qrCode").toString();
					String time=System.currentTimeMillis()+".jpg";
					String tmp=filepath+time;
					//生成支付宝二维码
					EncodeChanger.encoderQRCode(qrcode, tmp);
					
					mode.addAttribute("qrcode", time);
					
					System.out.println("返回信息="+getRespMessage);
				}else{
					System.out.println("签名失败");
				}
				
		} catch (Exception e) {
			e.printStackTrace();
		} 
		
		return "image";
	}
	
	@RequestMapping("refund")
	public String refund(MercModel model,ModelMap map){
		
		SortedMap<String, Object> head = new TreeMap<String, Object>();
		SortedMap<String, Object> body = new TreeMap<String, Object>();
		Map<String,Object> getRespMessage = new HashMap<String,Object>();
		head.put("version", "1.0.0");
		head.put("msgType", model.getMsgType());//交易类型
		head.put("reqDate",httpUtils.getTime("yyyyMMddHHmmss"));
		StringBuffer buffer = new StringBuffer();
		buffer.append("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
				+ "<merchant><head>");
		String headXml = PublicUtil.mapToXmlString(head);
		buffer.append(headXml+"</head>"
				+ "<body>");
		
		body.put("refundAmount", model.getTotalAmount());//退款金额
		body.put("oriReqMsgId", model.getOrderId());//退款订单号
		body.put("refundReason", "");//退款 原因
		
		String bodyXml= PublicUtil.mapToXmlString(body);
		buffer.append(bodyXml+"</body>"
				+ "</merchant>");
		String xml = buffer.toString();
		
		System.out.println(xml);
		String en_xml="";
		
		try {
			en_xml = new String(Base64.encodeBase64(xml.getBytes()));
		} catch (Exception e1) {
			e1.printStackTrace();
		}
		String privatepath =privatePath;//商户私钥
		String publicpath =publicPath;//现代金控公钥
		String signData="";
		try {
			PrivateKey  priKey=	RSAPemCoder.getPrivateKeyFromPem(privatepath);
			signData = RSAPemCoder.sign(xml.getBytes(), priKey);
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		List<NameValuePair> nvps =  new ArrayList<NameValuePair>();
		String url=model.getServerUrl();//请求地址 测试环境：生产环境：
		nvps.add(new BasicNameValuePair("xmlData", en_xml));
		nvps.add(new BasicNameValuePair("tranCode","SMZF004"));
		nvps.add(new BasicNameValuePair("signData", signData));//版本号
		nvps.add(new BasicNameValuePair("merchantId", model.getMerchantId()));//版本号
		String respXml=null;
		System.out.println("参数="+nvps.toString());
		byte[] mString = null;
		try {
			mString = HttpClient4Util.getInstance().doPost(url, null, nvps);
			respXml = new String(mString, "utf-8");
			System.out.println("返回信息11="+respXml );
			JSONObject jsonObject = JSONObject.fromObject(respXml);
			String resEncryptData = jsonObject.getString("encryptData");
			respXml = new String(Base64.decodeBase64(resEncryptData), "utf-8");
			System.out.println("返回信息xml="+respXml);
			String sign = jsonObject.getString("sign");
			System.out.println("返回的签名值为="+sign);
			//验签
			PublicKey  pubKey=	RSAPemCoder.getPublicKey(publicpath,"PEM");
			System.out.println("======PublicKey路径："+pubKey.getAlgorithm());
			if(RSAPemCoder.checksign(pubKey, respXml, sign, "SHA1WithRSA")){
				System.out.println("签名通过");
				getRespMessage=PublicUtil.xmlToMap(respXml);
				System.out.println("返回信息="+getRespMessage);
			}else{
				System.out.println("签名失败");
			}
		} catch (Exception e) {
			e.printStackTrace();
		} 
		return"";
				
	}
	@RequestMapping("search")
	public String transactionSearch(MercModel model,ModelMap map){
		SortedMap<String, Object> head = new TreeMap<String, Object>();
		SortedMap<String, Object> body = new TreeMap<String, Object>();
		Map<String,Object> getRespMessage = new HashMap<String,Object>();
		head.put("version", "1.0.0");
		head.put("msgType", model.getMsgType());//交易类型 01 支付宝 02 微信
		head.put("reqDate",httpUtils.getTime("yyyyMMddHHmmss"));
		StringBuffer buffer = new StringBuffer();
		buffer.append("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
				+ "<merchant><head>");
		String headXml = PublicUtil.mapToXmlString(head);
		buffer.append(headXml+"</head>"
				+ "<body>");
		body.put("oriReqMsgId", model.getOrderId());//商户订单号
		
		String bodyXml= PublicUtil.mapToXmlString(body);
		buffer.append(bodyXml+"</body>"
				+ "</merchant>");
		String xml = buffer.toString();
		
		String en_xml="";
		
		try {
			en_xml = new String(Base64.encodeBase64(xml.getBytes()));
			System.out.println("加密后的en_xml="+en_xml);
		
			System.out.println("解密后的en_xml="+Base64.decodeBase64(en_xml));
		} catch (Exception e1) {
			e1.printStackTrace();
		}
		

		String privatepath =privatePath;//商户私钥
		String publicpath =publicPath;//现代金控公钥
		String signData="";
		try {
			PrivateKey  priKey=	RSAPemCoder.getPrivateKeyFromPem(privatepath);
			signData = RSAPemCoder.sign(xml.getBytes(), priKey);
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		List<NameValuePair> nvps =  new ArrayList<NameValuePair>();
		String url=model.getServerUrl();//请求地址 测试环境：生产环境：
		nvps.add(new BasicNameValuePair("xmlData", en_xml));
		nvps.add(new BasicNameValuePair("tranCode","SMZF006"));
		nvps.add(new BasicNameValuePair("reqOrdId", model.getOrderId()));//订单号
		nvps.add(new BasicNameValuePair("signData", signData));//版本号
		nvps.add(new BasicNameValuePair("merchantId", model.getMerchantId()));//版本号
		String respXml=null;
		byte[] mString = null;
		try {
				mString = HttpClient4Util.getInstance().doPost(url, null, nvps);
				respXml = new String(mString, "utf-8");
				System.out.println("返回信息11="+respXml );
				JSONObject jsonObject = JSONObject.fromObject(respXml);
				String resEncryptData = jsonObject.getString("encryptData");
				respXml = new String(Base64.decodeBase64(resEncryptData), "utf-8");
				System.out.println("返回信息xml="+respXml);
				String sign = jsonObject.getString("sign");
				System.out.println("返回的签名值为="+sign);
				//验签
				PublicKey  pubKey=	RSAPemCoder.getPublicKey(publicpath,"PEM");
				System.out.println("======PublicKey路径："+pubKey.getAlgorithm());
				if(RSAPemCoder.checksign(pubKey, respXml, sign, "SHA1WithRSA")){
					System.out.println("签名通过");
					getRespMessage=PublicUtil.xmlToMap(respXml);
					System.out.println("返回信息="+getRespMessage);
				}else{
					System.out.println("签名失败");
				}
		} catch (Exception e) {
			e.printStackTrace();
		} 
		
		return "";
	}
	@RequestMapping("callBack")
	@ResponseBody
	public String callBack(MercModel model,ModelMap map){
		
		System.out.println("11111111111111111111111111111");
		
		return "0000";
	}
}
