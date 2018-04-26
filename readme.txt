Changes:
1. company的schema改了，加了cusername和cpassword
2. company的样本数据改了，加了上面的两样
3. student和company的username也是不能重复的，类似primarykey, 但是因为不能把id和username同时设为id，所以是在前端进行不能重复的检查的（因为登陆的时候，用的是username，username不能重复）

问题：
ww: 必填项如果没有填，student退回到ssign up时，之前选择的student丢失
zq: 注册之后是否回到登录页面还是直接进我的主页

开始-startpage.html
ww: 学生公司注册登录
zq: 学生公司登陆后注册后主页
