using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace B2C.Models
{
    public class B2CInfo
    {
        public string version { get; set; }//版本号
        public string reqDate { get; set; }//请求时间
        public string totalAmount { get; set; }//金额 订单金额以分为单位
        public string cardType { get; set; }//银行卡类型
        public string reqOrdId { get; set; }//订单号
        public string productName { get; set; }//产品名称
        public string productId { get; set; }//产品ID
        public string productDesc { get; set; }//产品描述
        public string showUrl { get; set; }//展示地址
        public string bankAbbr { get; set; }//银行编码
        public string pageReturnUrl { get; set; }//同步回调地址
        public string offlineNotifyUrl { get; set; }//后台回调地址
        public string postUrl { get; set; }//请求地址
        public string purchaserId { get; set; }//买者标识
        public string tranCode { get; set; }//交易码
        public string merchantId { get; set; }//商户号
        public string currency { get; set; } //币种
        public string validUnit { get; set; }//订单有效单位，只能以一下枚举值 00-分 01-小时 03-月
        public string validNum { get; set; }//订单有效数量
        public string backParam { get; set; }//原样返回商户数据
        public string orderTime { get; set; }//订单时间
        public string tradeNo { get; set; }//交易码
        public string payTime { get; set; }//支付时间
        public string fee { get; set; }//支付费用
        public string acDate { get; set; }//会计时间
        public string status { get; set; }//支付状态
        public string returnUrl { get; set; }//返回地址
        public string offlineUrl { get; set; }//异步回调
        public string refundAmount { get; set; }//退款金额
    }
}
