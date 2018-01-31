package com.cn.util;
/** 
 * @author 作者 E-mail: 
 * @version 创建时间：2017年12月11日 下午2:04:52 
 * 类说明 
 */
import java.io.BufferedInputStream;
import java.io.FileInputStream;
import java.io.InputStream; 
import java.util.Iterator;
import java.util.Properties; 

public class GetProperty {

	 public static String privatePath ;
	 
	 public static String publicPath;
	 
	 public static String filepath;
	 
     static {    	
    	  Properties prop = new Properties();     
          try{
              //读取属性文件a.properties
              InputStream in = new BufferedInputStream (new FileInputStream("C:\\Users\\lwj\\Desktop\\项目文档\\hlw\\smzf_xdjk_demo\\WebContent\\config\\config.properties"));
              prop.load(in);     ///加载属性列表
              privatePath = prop.getProperty("privatePath").trim();   
              publicPath = prop.getProperty("publicPath").trim(); 
              filepath = prop.getProperty("filepath").trim();
              in.close();
          }
          catch(Exception e){
        	  e.printStackTrace();   
          }
         
    }
}