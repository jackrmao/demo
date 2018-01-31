using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Configuration;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using B2C.Models;
using Microsoft.Extensions.Options;
using MvcMovie.Utils;
using B2C.Utils;

namespace B2C.Controllers
{
    public class HomeController : Controller
    {
        public AppSetting appSetting;
       
        public IActionResult Index()
        {
            return View();
        }
        public HomeController(IOptions<AppSetting> setting)
        {
            appSetting = setting.Value;
        }
        //A
        public IActionResult About()
        {
            ViewData["Message"] = "Your application description page.";

            return View();
        }

        public IActionResult Contact()
        {
            ViewData["Message"] = "Your contact page.";

            return View();
        }

        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
        //支付信息录入界面
        public ActionResult B2C(Models.B2CInfo order) {
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            ViewData["order"] = order;
            return View();
            
        }
        //查询录入界面
        public ActionResult OrderQuery(Models.B2CInfo order)
        {
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            ViewData["order"] = order;
            return View();

        }
        //查询信息确认
        public ActionResult Search(Models.B2CInfo order)
        {
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            ViewData["order"] = order;
            return View();

        }
        //提交查询
        public ActionResult SearchPost(Models.B2CInfo order)
        {
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            string xml = Utils.DataUtils.getSearchXml(order);
            byte[] bytes = System.Text.Encoding.UTF8.GetBytes(xml);
            //转成 Base64 形式的 System.String  
            string xmlData = Convert.ToBase64String(bytes);
            string tranCode = "WGZF003";
            //私钥
            string privateKey = appSetting.privateKey;
            //公钥
            string publicKey = appSetting.publicKey;
            //私钥签名
            string sign = RSAFromPkcs8.sign(xml, privateKey, "UTF-8");
            //发送数据拼接
            string param = "xmlData=" + xmlData + "&tranCode=" + tranCode + "&reqOrdId=" + order.reqOrdId + "&signData=" + sign + "&merchantId=" + order.merchantId;

            string response = HttpClient.HttpPost(order.postUrl, param);
            ViewData["order"] = order;
            return View();

        }
        //退款提交
        public ActionResult Refund(Models.B2CInfo order)
        {
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            string xml = Utils.DataUtils.getRefundString(order);
            byte[] bytes = System.Text.Encoding.UTF8.GetBytes(xml);
            //转成 Base64 形式的 System.String  
            string xmlData = Convert.ToBase64String(bytes);
            string tranCode = "WGZF002";
            //私钥
            string privateKey = appSetting.privateKey;
            //公钥
            string publicKey = appSetting.publicKey;
            //私钥签名
            string sign = RSAFromPkcs8.sign(xml, privateKey, "UTF-8");
            //发送数据拼接
            string param = "xmlData=" + xmlData + "&tranCode=" + tranCode + "&reqOrdId=" + order.reqOrdId + "&signData=" + sign + "&merchantId=" + order.merchantId;

            string response = HttpClient.HttpPost(order.postUrl, param);
            ViewData["order"] = order;
            return View();

        }
        //退款录入
        public ActionResult RefundPay(Models.B2CInfo order)
        {
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            ViewData["order"] = order;
            return View();

        }
        //支付信息确认页面
        public ActionResult Creat(Models.B2CInfo order)
        {
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            ViewData["order"] = order;
            return View();
        }
        //支付提交
        public ActionResult PayPost(Models.B2CInfo order)
        {
            //组装xml
            String xml =DataUtils.getXmlString(order);
            byte[] bytes = System.Text.Encoding.UTF8.GetBytes(xml);
            //转成 Base64 形式的 System.String  
            string xmlData = Convert.ToBase64String(bytes);
            string tranCode = appSetting.postPayCode;
            //私钥
            string privateKey = appSetting.privateKey;
            //公钥
            string publicKey = appSetting.publicKey;
            string sign = RSAFromPkcs8.sign(xml, privateKey, "UTF-8");
            string merchantId = order.merchantId;
            //发送数据拼接
            string param = "xmlData=" + xmlData + "&tranCode=WGZF001" + "&reqOrdId=" + order.reqOrdId + "&signData=" + sign + "&merchantId=" + order.merchantId;
            string response = HttpClient.HttpPost(order.postUrl, param);
            B2C.Models.RecallObject recall = JsonHelper.JsonStringToObj<B2C.Models.RecallObject>(response);
            //返回数据签名验证后生成二维码
            // string ec = recall.encryptData;
            string recallstring = DataUtils.DecodeBase64("utf-8", recall.encryptData);
            if (RSAFromPkcs8.verify(recallstring, recall.sign, publicKey, "UTF-8"))
            {
                string url = DataUtils.getValue(recallstring, "qrCode");
                if (order.tranCode.Equals("01"))
                {
                    //支付宝
                   // GenerateQRCode.GenerateQRByThoughtWorks(url, DataUtils.getValue(recallstring, "reqOrdId"), memoryAddress);
                }
                else
                {
                    //微信
                 //   GenerateQRCode.GenerateQRByThoughtWorks(url, DataUtils.getValue(recallstring, "reqOrdId"), memoryAddress);
                }

            }
            string result = Newtonsoft.Json.JsonConvert.SerializeObject(order);
            ViewData["merchant"] = order;
            return View();
        }
    }
}
