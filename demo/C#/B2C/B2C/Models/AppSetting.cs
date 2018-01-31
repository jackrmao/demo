using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace B2C.Models
{
    public class AppSetting
    {
        public string version { get; set; }
        public string cretpath { get; set; }
        public string path { get; set; }
        public string pageReturnUrl { get; set; }
        public string req_url { get; set; }
        public string offlineNotifyUrl { get; set; }
        public string service { get; set; }
        public string postPayCode { get; set; }
        public string privateKey { get; set; }
        public string publicKey { get; set; }


    }
}
