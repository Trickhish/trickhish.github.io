var isc = false;
var sct;
var lsa=window.scrollY;
var ttc=0;
var ars = false;
var phc=0;
var lch=0;
var onscrollend=function(){};

/* Time Parameter : the higher the slower */
var tp = 50;

function scrollend(tc){
    if (ars==true) {
        ars=false;
    } else {
        ars=true;

        var sa = window.scrollY;
        var ws = window.innerHeight

        var yc;
        var l = [Math.abs(0-tc), Math.abs(ws-tc), Math.abs((ws*2)-tc), Math.abs((ws*3)-tc)];
        if (l[0] < l[1] && l[0] < l[2] && l[0] < l[3]) {
            //console.log('from top');
            yc=0;
        } else if (l[1] < l[0] && l[1] < l[2] && l[1]<l[3]) {
            //console.log('from middle top');
            yc=ws;
        } else if (l[2] < l[0] && l[2] < l[1] && l[2]<l[3]){
            //console.log('from middle bottom');
            yc=ws*2;
        } else {
            //console.log('from bottom');
            yc=ws*3;
        }

        if (sa>tc) {
            yc+=ws;
        }else if (sa<tc) {
            yc-=ws;
        }

        window.scroll({top: yc, left: 0, behavior: 'smooth'});
    }
    lo=onscrollend;
    onscrollend();
    if (lo == onscrollend) {
        onscrollend=function(){};
    }

}

document.body.onscroll=function(){
    scl();
    var sa = window.scrollY;
    var ws = window.innerHeight
    var t = Math.round(sa/ws*100)/100;
    var ch = Math.round(Math.abs(lsa-sa));

    if (ttc==0) {
        ttc=sa;
    }
    lsa=sa;

    //console.log(ch);

    /*
    if (ch<lch && ch<10 && ars==false) {
        if (phc>=3) {
            console.log('phase descendante');
            phc=0;
        } else {
            phc+=1;
        }
    }
     */
    
    if (lch<ch && ch>-200 && ars==false) {
        //clearTimeout(sct);
        //sct = setTimeout(function(){scrollend(ttc);ttc=0;}, tp);
    }

    lch=ch;


    clearTimeout(sct);
    sct = setTimeout(function(){scrollend(ttc);ttc=0;}, tp);
}

setInterval(function(){document.getElementById('ars').innerHTML = 'ars : '+ars;}, 100);