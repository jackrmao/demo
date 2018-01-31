using B2C.Models;
using System;
using System.Text;
using System.Xml;
using System.Xml.Linq;

namespace B2C.Utils
{
    public class DataUtils
    {
        public static string EncodeBase64(string code_type, string code)
        {
            string encode = "";
            byte[] bytes = Encoding.GetEncoding(code_type).GetBytes(code);
            try
            {
                encode = Convert.ToBase64String(bytes);
            }
            catch
            {
                encode = code;
            }
            return encode;
        }

        public static string DecodeBase64(string code_type, string code)
        {
            string decode = "";
            byte[] bytes = Convert.FromBase64String(code);
            try
            {
                decode = Encoding.GetEncoding(code_type).GetString(bytes);
            }
            catch
            {
                decode = code;
            }
            return decode;
        }
        public static string getValue(string xml, string nodeName)
        {
            string value = "";
            if (nodeName.Equals("qrCode"))
            {
                XElement root = XElement.Parse(@""+xml.Trim()+"");
                value = root.Element("body").Element("qrCode").Value;
            }
            else
            {
                XElement root = XElement.Parse(@""+xml.Trim()+"");
                value = root.Element("head").Element(nodeName).Value;
            }
            return value;
        }
        public static string getXmlString(B2C.Models.B2CInfo order)
        {
            String xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
            xml += "<merchant><head><version>";
            xml += "<![CDATA["+order.version+"]]>";
            xml += "</version><reqDate>";
            order.reqDate = DateTime.Now.ToString("yyyyMMddHHmmss");
            xml += "<![CDATA["+order.reqDate+"]]>";
            xml += "</reqDate></head><body><totalAmount>";
            xml += "<![CDATA["+order.totalAmount+"]]></totalAmount><cardType>";
            xml += "<![CDATA["+order.cardType+"]]></cardType><productName>";
            xml += "<![CDATA["+order.productName+"]]></productName><productId>";
            xml += "<![CDATA["+order.productId+"]]></productId><productDesc>";
            xml += "<![CDATA["+order.productDesc+"]]></productDesc><showUrl>";
            xml += "<![CDATA["+order.showUrl+"]]></showUrl><bankAbbr>";
            xml += "<![CDATA["+order.bankAbbr+"]]></bankAbbr><pageReturnUrl>";
            xml += "<![CDATA["+order.pageReturnUrl+"]]></pageReturnUrl><offlineNotifyUrl>";
            xml += "<![CDATA["+order.offlineNotifyUrl+"]]></offlineNotifyUrl><tranCode>";
            xml += "<![CDATA["+order.tranCode+"]]></tranCode><purchaserId>";
            xml += "<![CDATA["+order.purchaserId+"]]></purchaserId><validNum>";
            xml += "<![CDATA["+order.validNum+"]]></validNum><currency>";
            xml += "<![CDATA["+order.currency+"]]></currency><validUnit>";
            xml += "<![CDATA["+order.validUnit+"]]></validUnit><backParam>";
            xml += "<![CDATA["+order.backParam+"]]></backParam></body></merchant>";
            return xml;
        }
        public static string getSearchXml(B2C.Models.B2CInfo order)
        {
            String xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
            xml += "<merchant><head><version>";
            xml += "<![CDATA["+order.version+"]]>";
            xml += "</version><reqDate>";
            order.reqDate = DateTime.Now.ToString("yyyyMMddHHmmss");
            xml += "<![CDATA["+ order.reqDate+"]]>";
            xml += "</reqDate></head><body><reqOrdId>";
            xml += "<![CDATA["+order.reqOrdId+"]]>";
            xml += "</reqOrdId><tradeNo>";
            xml += "<![CDATA["+order.tradeNo+"]]>";
            xml += "</tradeNo><merchantId>";
            xml += "<![CDATA["+order.merchantId+"]]>";
            xml += "</merchantId><totalAmount>";
            xml += "<![CDATA["+order.totalAmount+"]]>";
            xml += "</totalAmount><bankAbbr>";
            xml += "<![CDATA["+order.bankAbbr+"]]>";
            xml += "</bankAbbr><purchaserId>";
            xml += "<![CDATA["+order.purchaserId+"]]>";
            xml += "</purchaserId><payTime>";
            xml += "<![CDATA["+order.payTime+"]]>";
            xml += "</payTime><fee>";
            xml += "<![CDATA["+order.fee+"]]>";
            xml += "</fee><status>";
            xml += "<![CDATA["+order.status+"]]>";
            xml += "</status><backParam>";
            xml += "<![CDATA["+order.backParam+"]]>";
            xml += "</backParam><returnUrl>";
            xml += "<![CDATA["+order.returnUrl+"]]>";
            xml += "</returnUrl></body></merchant>";
            return xml;
        }

        public static string getRefundString(B2C.Models.B2CInfo order)
        {
            string xml = "";
            // order.orderTime = DateTime.Now.ToString("yyyyMMddHHmmss");
            xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
            xml += "<merchant><head><version>";
            xml += "<![CDATA["+order.version+"]]>";//版本号
            xml += "</version><reqDate>";
            xml += "<![CDATA["+order.reqDate+"]]>";//请求时间
            xml += "</reqDate><tranCode>";
            xml += "<![CDATA["+order.tranCode+"]]>";//退款时间
            xml += "</tranCode></head><body><refundAmount>";
            xml += "<![CDATA["+order.refundAmount + "]]>";//退款金额
            xml += "</refundAmount><merchantId>";
            xml += "<![CDATA["+order.merchantId+"]]>";//商户号
            xml += "</merchantId><reqOrdId>";
            xml += "<![CDATA["+order.reqOrdId+"]]>";//订单Id
            xml += "</reqOrdId></body></merchant>";
            return xml;
        }

        public static string getCallBack(RecallObject reCall)
        {
            string xml = "";
            xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
            xml += "<merchant><head><version>";
            xml += "<![CDATA["+reCall.version+"]]>";//版本号
            xml += "</version><msgType>";
            xml += "<![CDATA["+reCall.msgType+"]]>";//支付方式1 支付宝 2 微信
            xml += "</msgType><reqDate>";
            xml += "<![CDATA["+reCall.orderTime+"]]>";//订单时间
            xml += "</reqDate><respMsg>"+"<![CDATA["+reCall.respMsg+"]]>";//回执信息
            xml += "</respMsg><respType>"+"<![CDATA["+reCall.respType+"]]>";//消息提示类型
            xml += "</head><body><buyerId>";
            xml += "<![CDATA["+reCall.buyerId+"]]>";//买方ID
            xml += "</buyerId><reqOrdId>";
            xml += "<![CDATA["+reCall.reqOrdId+"]]>";//订单ID
            xml += "</reqOrdId><totalAmount>";
            xml += "<![CDATA["+reCall.totalAmount+"]]>";//金额
            xml += "</totalAmount></body></merchant>";
            return xml;

        }
        public static RecallObject getRecall(string xml)
        {
            RecallObject recall = new RecallObject();
            recall.version = getValue(xml, "version");
            recall.msgType = getValue(xml, "msgType");
            recall.orderId = getValue(xml, "reqOrdId");
            recall.orderTime = getValue(xml, "reqDate");
            recall.respDate = getValue(xml, "respDate");
            recall.respType = getValue(xml, "respType");
            recall.respCode = getValue(xml, "respCode");
            recall.respMsg = getValue(xml, "respMsg");
            return recall;

        }

    }

}