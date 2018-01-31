using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace B2C.Models
{
    public class RecallObject
    {
        public string encryptData { get; set; }//base64格式的xml
        public string sign { get; set; }//加密的xml
        public string version { get; set; }//版本号
        public string merchantId { get; set; }//商户ID
        public string orderId { get; set; }//订单Id
        public string orderTime { get; set; }//订单时间
        public string serverUrl { get; set; }
        public string respType { get; set; }
        public string respCode { get; set; }
        public string respMsg { get; set; }
        public string respDate { get; set; }
        public string msgType { get; set; }
        public string reqDate { get; set; }
        public string buyerId { get; set; }
        public string totalAmount { get; set; }
        public string reqOrdId { get; set; }
    }
}