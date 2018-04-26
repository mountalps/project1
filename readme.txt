Changes:
1. company的schema改了，加了cusername和cpassword
2. company的样本数据改了，加了上面的两样
3. student和company的username也设成primarykey（因为登陆的时候，用的是username），作为ID使用


问题：
必填项如果没有填，student退回到ssign up时，之前选择的student丢失
