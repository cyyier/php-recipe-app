//计时器
var end_time;

function theTimeFunction(the_second) {
    var the_time = the_second*1000 ;
    var d=new Date();    //点击开始后的时间
    var t = d.getTime();
    end_time = the_time + t; //结束的时间
    var int=self.setInterval("showClockFunction()",1000);//显示剩余时间
    setTimeout(alertFuction,the_time); //计时结束时运行，弹出提示窗口和发出声音


}
function alertFuction() {
    //发出声音
    let audio = new Audio('alarm.mp3');
    audio.play();



}

function showClockFunction() {
    var now_time = new Date(); //调用函数后的当前时间
    var print_time = end_time - now_time.getTime(); //应该打印再屏幕上的剩余时间
    if(print_time <= 0){print_time=0;}
    print_time /= 1000; //换算毫秒成秒
    var m=print_time>=60 ? parseInt(print_time/60) : 0; //要打印的分钟数,不用parseInt会出现小数点的秒数
    var s=parseInt(print_time-m*60);//要打印的秒数
    print_time = m + '分' + s + '秒';//要打印的字符串

    document.getElementById("clock").innerText=print_time;


    //TODO：增加暂停功能 不能重复点击 文字显示在按钮上
}