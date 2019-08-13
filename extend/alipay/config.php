<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016100200646024",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAscouYZrNGfauI2vmzPa2F4h7TgBO0P9GkiRc4jScliQF252gGPCfXfdtaB/2l2tgwNskUBUWbDhJLA/fW1hu+p08/ses2ColEkEKYCqvWkYznVxIH4P+kzC2lA5YyDFN+h1B/nAX14KRO0PnCKyTJHFg89Pa9v6GX5Z+dhwo0hDw7/XnnG7JHhbcoWDNrlgroBTK8cQ8eUB6JSRnT0Fh7sllTQarlS5rNn/KuqcqAQnPQVhKq814R8m4pvCrKfPrfpwh+TpmudZvI+eZVHYJjRKCxcMGoWjnPv7965h0oSSK+BE5dlE5eyVNPI7S4PkYjusH0eD0E7ScoDjC0zC7zwIDAQABAoIBAQCndZlERAvF1czl/j8xdXvEJMCHktCqGJg/FNMMGaQX4yxFVG20sAhb+K7rcZfRvckvPfoxF/u7yTRatUSbhGtb0PjfvfG21dN/IxYDyJDMBe2d3YrtbGU//JUsVWsYfSBGYoKDhs9eJVRoLygQyoP5wnUglL7dAJZOuLC6zQFCAjJdiaJV6Lw58q0hUfLrlVNRE/6vSCc5VBVuBtC3VeVUrAQ4YhDnvnPAiNFlXRyKOaeOR/J0bRwuo6JYM0hLnrSohu8me5A0zGQ6kf02O89WDmETjEP4NQjK79wAg80ENvr8GEbY0Dppp91q/pyZ5gGH4H5MTwQTz5niQotozI45AoGBAOKi8msbyKUWx5rFEHrlaYsmv8mtjCShMf569t+LJcuR49L3JlFhRJWUYQAd6YUECabHmJc7HVygbvqn6ZR1qFQMAfM8sdI2OfFx9dDPKSU21xpgPBPOSMcj/DsU85jhoR1d55JSR923YJTA5S9evat5WdFlEPz28dFyVTmtUKmtAoGBAMjTF15L6MXIEemDgIQ6sRzJm3l2Y1IvKHhc+BuR91BD5oBDvmo6azg8d4Y8v6CR9i1C/Nbmp9pHaSMUaogHq3XXntdWZgGto+j/tPqBZ/VFLyxSNmAYo+FzSeXG1whc+QYvJfhv6aTprS1J03w3ZwTu10lTEMRmz02CKmU9jCLrAoGAJAtUULKXg6IO1s+WomUQFyBviiy+yCiW4ek+kCj6NtkaCbhi8LhuhveVQcaAGDafLlY6L3soXU3quJSx8nmP7uYF/WBey5byOjMsrCv2WEPTjA9YHrJFIt7XQ7I+V8cyr4/6v2u0oE+E3cOb75+6vKXNIh9Xx1Oi+/OaGFU3KfUCgYAGEgNp0UeW+uY3tcbjuFZ0NU/iywZTjKNfiAfj5XShU3wbMnEGCwAEsic2wo1UUDUtxxGXeV9nhLMT4WEa/YhcRolBnxX0RQhoWZph3BmFW3MClvWX0AbcIL0CGhGT6iOI4VH3gYKBfqLCdLHU1mPhzUpqp/0gwq7Pe/jGGKcswwKBgQC+N/+Ea0QBnKjFD1GmVejxhtaEbRS1j0OpqyDp7jCe+3dYAtW1mV4P9BWaR+uk+RIgi4PQoDmPoEQg/52pO7sP+vJ5enYAOewXaxLtqkdHje3bw6IXKnxhxNb3g42wZzY6wLqvDuSwCTdauw87THRxU14DLI2N4ckxMdu5Hu/T4g==",
		
		//异步通知地址
		'notify_url' => "http://shop.com/api/alipay/notifyurl",
		
		//同步跳转
		'return_url' => "http://shop.com/api/alipay/returnurl",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkGo0vaF1hIeQEH87sloEEegeMViUTkK7oPbV6SvnD2GPzpd4xx1+Q3i/e0Logs0Mx4SkH8v++Q8GCymO2UrwubyT0f8sUlTfcDR8IAeJ9AoQfKVMYvxuJTliRRT/KL1Iia2VQfhl8D1enMibJl5gttHhn/2kQi5wB7Q1uAhrxH94vs/xkN9YyiwVKSFbUy1Cmb1eY7bsgL/y/bKkqta+f1czset5MUGUa9tYImQWCMgBAa6MTNZ6ROleOf2IW6Np1UvqCOxjwLeihrXvavU/CQoY/E+MPILcwXxFtEQbNzH1vt9ot2ik3/QpsT5eGi00Ym+TSN06qldNg5U1mcwv7QIDAQAB",
);