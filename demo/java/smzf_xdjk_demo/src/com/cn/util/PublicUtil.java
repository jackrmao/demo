package com.cn.util;

import java.awt.Color;
import java.awt.Graphics2D;
import java.awt.image.BufferedImage;
import java.io.BufferedReader;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URL;
import java.security.MessageDigest;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;
import java.util.SortedMap;

import org.dom4j.Document;
import org.dom4j.DocumentHelper;
import org.dom4j.Element;


public class PublicUtil {
	/*
	 * map to String
	 */
	public static String mapToStringAndTrim(SortedMap<String, Object> sortedMap){
		StringBuffer sb = new StringBuffer();
		Iterator it = sortedMap.entrySet().iterator();
		while (it.hasNext()) {
			Map.Entry entry = (Map.Entry)it.next();
			String key = entry.getKey().toString().trim();
			if(entry.getValue()==null){
				continue;
			}
			String value = entry.getValue().toString().trim();
			if (!"".equals(value) && value!=null) {
				sb.append(key+"="+value+"&");
			}
		}
		return sb.substring(0,sb.length()-1);
	}
	/**
     * map 转换成String
     * @param sortedMap
     * @return
     */
    public static String mapToXmlString(SortedMap<String, Object> sortedMap){
   	 StringBuffer sb = new StringBuffer();
   	  Iterator it =	sortedMap.entrySet().iterator();
   	
          while (it.hasNext()) {
              Map.Entry entry = (Map.Entry)it.next();
              String key = entry.getKey().toString().trim();
              if(entry.getValue()==null){
           	   continue;
              }
              String value = entry.getValue().toString().trim();
              if (!"".equals(value) && value!=null) {
           	   sb.append("<"+key+"><![CDATA["+value+"]]></"+key+">");
              }
          }
   	return sb.toString();
   }
    /**
     * 将xml转换为Map
     * @param xml
     * @return
     * @throws Exception
     */
    public static Map<String, Object> xmlToMap(String xml) throws Exception {
        return xmlDoc2Map(DocumentHelper.parseText(xml));
    }
    /**
     * 将xml文件转成Map
     * @param xmlDoc
     * @return
     */
    private static Map<String, Object> xmlDoc2Map(Document xmlDoc) {
        Map<String, Object> map = new HashMap<String, Object>();
        if (xmlDoc == null) {
            return map;
        }
        Element root = xmlDoc.getRootElement();
        for (Iterator iterator = root.elementIterator(); iterator.hasNext();) {
            Element e = (Element) iterator.next();
            List list = e.elements();
            if (list.size() > 0) {
                map.put(e.getName(), Dom2Map(e,map));
            } else {
                map.put(e.getName(), e.getText());
            }
        }
        return map;
    }
    private static Map Dom2Map(Element e,Map map){
        List list = e.elements();
        if(list.size() > 0){
            for (int i = 0;i < list.size(); i++) {
                Element iter = (Element) list.get(i);
                List mapList = new ArrayList();
                if (iter.elements().size() > 0) {
                    Map m = Dom2Map(iter,map);
                    if (map.get(iter.getName()) != null) {
                        Object obj = map.get(iter.getName());
                        if (!obj.getClass().getName().equals("java.util.ArrayList")) {
                            mapList = new ArrayList();
                            mapList.add(obj);
                            mapList.add(m);
                        }
                        if (obj.getClass().getName().equals("java.util.ArrayList")) {
                            mapList = (List) obj;
                            mapList.add(m);
                        }
                        map.put(iter.getName(), mapList);
                    } else {
                        map.putAll(m);
                    }
                } else {
                    if (map.get(iter.getName()) != null) {
                        Object obj = map.get(iter.getName());
                        if (!obj.getClass().getName().equals("java.util.ArrayList")) {
                            mapList = new ArrayList();
                            mapList.add(obj);
                            mapList.add(iter.getText());
                        }
                        if (obj.getClass().getName().equals("java.util.ArrayList")) {
                            mapList = (List) obj;
                            mapList.add(iter.getText());
                        }
                        map.put(iter.getName(), mapList);
                    } else {
                        map.put(iter.getName(), iter.getText());
                    }
                }
            }
        } else {
            map.put(e.getName(), e.getText());
        }
        return map;
    }
}
