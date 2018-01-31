package com.cn.util;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.io.File;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

import javax.imageio.ImageIO;

import com.swetake.util.Qrcode;

/**
 * @Title: EncodeChanger.java
 * @Package cn.ipays.gateway.utils
 * @Description: TODO
 * Copyright: Copyright (c) 2015 
 * Company:北京乐付通科技有限公司
 * 
 * @author Comsys-hanchao
 * @date 2015-1-16 下午3:34:53
 * @version V1.0
 */

public class EncodeChanger {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		String str = "0000||610422378899|李明|889.91|610422378859|李明|337.00|610422378822|李明|509.26";
		System.out.println(unicode2UnicodeEsc(str));
	}

	public static String unicode2UnicodeEsc(String uniStr) {
		StringBuffer ret = new StringBuffer();
		if (uniStr == null) {
			return null;
		}
		int maxLoop = uniStr.length();
		for (int i = 0; i < maxLoop; ++i) {
			char character = uniStr.charAt(i);
			if (character <= '') {
				ret.append(character);
			} else {
				ret.append("\\u");
				String hexStr = Integer.toHexString(character);
				int zeroCount = 4 - hexStr.length();
				for (int j = 0; j < zeroCount; ++j) {
					ret.append('0');
				}
				ret.append(hexStr);
			}
		}
		return ret.toString();
	}

	public static String unicodeEsc2Unicode(String unicodeStr) {
		if (unicodeStr == null) {
			return null;
		}

		StringBuffer retBuf = new StringBuffer();
		int maxLoop = unicodeStr.length();
		for (int i = 0; i < maxLoop; ++i) {
			if (unicodeStr.charAt(i) == '\\') {
				if ((i < maxLoop - 5)
						&& (((unicodeStr.charAt(i + 1) == 'u') || (unicodeStr
								.charAt(i + 1) == 'U'))))
					try {
						retBuf.append((char) Integer.parseInt(
								unicodeStr.substring(i + 2, i + 6), 16));
						i += 5;
					} catch (NumberFormatException e) {
						retBuf.append(unicodeStr.charAt(i));
					}
				else
					retBuf.append(unicodeStr.charAt(i));
			} else {
				retBuf.append(unicodeStr.charAt(i));
			}
		}

		return retBuf.toString();
	}
	
	/**
	 * 
	 * 生成二维码(QRCode)图片
	 * 
	 * @param content
	 * 
	 * @param imgPath
	 * 
	 */

	public static void encoderQRCode(String content, String path)
			throws Exception {
		Qrcode qrcodeHandler = new Qrcode();

		qrcodeHandler.setQrcodeErrorCorrect('M');

		qrcodeHandler.setQrcodeEncodeMode('B');

		qrcodeHandler.setQrcodeVersion(7);
		
		System.out.println("二维码地址："+content);

		byte[] contentBytes = content.getBytes("gb2312");

		BufferedImage bufImg = new BufferedImage(140, 140,BufferedImage.TYPE_INT_RGB);

		Graphics2D gs = bufImg.createGraphics();

		gs.setBackground(Color.WHITE);

		gs.clearRect(0, 0, 140, 140);

		// 设定图像颜色> BLACK

		gs.setColor(Color.BLACK);

		// 设置偏移量 不设置可能导致解析出错

		int pixoff = 2;

		// 输出内容> 二维码

		if (contentBytes.length > 0 && contentBytes.length < 120) {

			boolean[][] codeOut = qrcodeHandler.calQrcode(contentBytes);

			for (int i = 0; i < codeOut.length; i++) {

				for (int j = 0; j < codeOut.length; j++) {

					if (codeOut[j][i]) {

						gs.fillRect(j * 3 + pixoff, i * 3 + pixoff, 3, 3);

					}
				}
			}
		} 
		else {
			System.err.println("QRCode content bytes length = "

			+ contentBytes.length + " not in [ 0,120 ]. ");

		}
		gs.dispose();
		bufImg.flush();
		// 生成二维码QRCode图片
		ImageIO.write(bufImg, "png", new File(path));
	}
	/*
	 * 设置存储二维码的本地路径
	 */
	public static String setQrCodePath(String aliQrCodePath) throws Exception{
		Date now = new Date();
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyyMMdd");//日期格式 
		String curDate = dateFormat.format(now);
		System.out.println(curDate);
		String lastDate = getLastDayBefore(curDate,"yyyyMMdd");
		String qrCodePath = aliQrCodePath + "/" + curDate;
		String qrCodePathOld = aliQrCodePath + "/" + lastDate;
		File file = new File(qrCodePath);
		File fileOld = new File(qrCodePathOld);
		//创建当天的路径
		createPath(file);
		//删除前一天的路径，包含路径下的文件，一并删除
		deletePath(fileOld);
		return qrCodePath;
	}
	/*
	 * 获得指定日期的前一天 
	 */
	public static String getLastDayBefore(String curDate,String format) {
		Calendar c = Calendar.getInstance();
		Date date = null;
		try {
			date = new SimpleDateFormat(format).parse(curDate);
		}
		catch (ParseException e) {
            e.printStackTrace();
        }
        c.setTime(date);
        int day = c.get(Calendar.DATE);
        c.set(Calendar.DATE, day - 1);
        String dayBefore = new SimpleDateFormat(format).format(c.getTime());
        return dayBefore;
    }
	/*
	 * 创建文件夹
	 */
	public static void createPath(File file) throws Exception{
		boolean isPathExist = file.exists() && file.isDirectory();
		if(!isPathExist){
			file.mkdir();
			System.out.println("文件夹创建成功!");
		}
	}
	/*
	 * 删除文件夹
	 */
	public static void deletePath(File fileOld) throws Exception{
		boolean isPathExist = fileOld.exists() && fileOld.isDirectory();
		if(isPathExist){
			if(deleteDir(fileOld)){
				System.out.println("文件删除成功");
			}
		}
	}
	/*
	 * 删除文件
	 */
	private static boolean deleteDir(File dir) {
		if (dir.isDirectory()) {
			String[] children = dir.list();
			for (int i=0; i<children.length; i++) {
				boolean success = deleteDir(new File(dir, children[i]));
				if (!success) {
					return false;
				}
			}
		}
		// 目录此时为空，可以删除
		return dir.delete();
	}
}
