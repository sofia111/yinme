/*! modernizr 3.3.1 (Custom Build) | MIT *
 * https://modernizr.com/download/?-touchevents-video-prefixes-setclasses-teststyles !*/
!function(e,n,o){function t(e,n){return typeof e===n}function a(){var e,n,o,a,s,i,r;for(var l in d)if(d.hasOwnProperty(l)){if(e=[],n=d[l],n.name&&(e.push(n.name.toLowerCase()),n.options&&n.options.aliases&&n.options.aliases.length))for(o=0;o<n.options.aliases.length;o++)e.push(n.options.aliases[o].toLowerCase());for(a=t(n.fn,"function")?n.fn():n.fn,s=0;s<e.length;s++)i=e[s],r=i.split("."),1===r.length?Modernizr[r[0]]=a:(!Modernizr[r[0]]||Modernizr[r[0]]instanceof Boolean||(Modernizr[r[0]]=new Boolean(Modernizr[r[0]])),Modernizr[r[0]][r[1]]=a),c.push((a?"":"no-")+r.join("-"))}}function s(e){var n=u.className,o=Modernizr._config.classPrefix||"";if(v&&(n=n.baseVal),Modernizr._config.enableJSClass){var t=new RegExp("(^|\\s)"+o+"no-js(\\s|$)");n=n.replace(t,"$1"+o+"js$2")}Modernizr._config.enableClasses&&(n+=" "+o+e.join(" "+o),v?u.className.baseVal=n:u.className=n)}function i(){return"function"!=typeof n.createElement?n.createElement(arguments[0]):v?n.createElementNS.call(n,"http://www.w3.org/2000/svg",arguments[0]):n.createElement.apply(n,arguments)}function r(){var e=n.body;return e||(e=i(v?"svg":"body"),e.fake=!0),e}function l(e,o,t,a){var s,l,c,d,f="modernizr",p=i("div"),v=r();if(parseInt(t,10))for(;t--;)c=i("div"),c.id=a?a[t]:f+(t+1),p.appendChild(c);return s=i("style"),s.type="text/css",s.id="s"+f,(v.fake?v:p).appendChild(s),v.appendChild(p),s.styleSheet?s.styleSheet.cssText=e:s.appendChild(n.createTextNode(e)),p.id=f,v.fake&&(v.style.background="",v.style.overflow="hidden",d=u.style.overflow,u.style.overflow="hidden",u.appendChild(v)),l=o(p,e),v.fake?(v.parentNode.removeChild(v),u.style.overflow=d,u.offsetHeight):p.parentNode.removeChild(p),!!l}var c=[],d=[],f={_version:"3.3.1",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,n){var o=this;setTimeout(function(){n(o[e])},0)},addTest:function(e,n,o){d.push({name:e,fn:n,options:o})},addAsyncTest:function(e){d.push({name:null,fn:e})}},Modernizr=function(){};Modernizr.prototype=f,Modernizr=new Modernizr;var p=f._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):["",""];f._prefixes=p;var u=n.documentElement,v="svg"===u.nodeName.toLowerCase();Modernizr.addTest("video",function(){var e=i("video"),n=!1;try{(n=!!e.canPlayType)&&(n=new Boolean(n),n.ogg=e.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,""),n.h264=e.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,""),n.webm=e.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,""),n.vp9=e.canPlayType('video/webm; codecs="vp9"').replace(/^no$/,""),n.hls=e.canPlayType('application/x-mpegURL; codecs="avc1.42E01E"').replace(/^no$/,""))}catch(o){}return n});var h=f.testStyles=l;Modernizr.addTest("touchevents",function(){var o;if("ontouchstart"in e||e.DocumentTouch&&n instanceof DocumentTouch)o=!0;else{var t=["@media (",p.join("touch-enabled),("),"heartz",")","{#modernizr{top:9px;position:absolute}}"].join("");h(t,function(e){o=9===e.offsetTop})}return o}),a(),s(c),delete f.addTest,delete f.addAsyncTest;for(var m=0;m<Modernizr._q.length;m++)Modernizr._q[m]();e.Modernizr=Modernizr}(window,document);

/**
 * bootbox.js v4.4.0
 * http://bootboxjs.com/license.txt
 */
!function(a,b){"use strict";"function"==typeof define&&define.amd?define(["jquery"],b):"object"==typeof exports?module.exports=b(require("jquery")):a.bootbox=b(a.jQuery)}(this,function a(b,c){"use strict";function d(a){var b=q[o.locale];return b?b[a]:q.en[a]}function e(a,c,d){a.stopPropagation(),a.preventDefault();var e=b.isFunction(d)&&d.call(c,a)===!1;e||c.modal("hide")}function f(a){var b,c=0;for(b in a)c++;return c}function g(a,c){var d=0;b.each(a,function(a,b){c(a,b,d++)})}function h(a){var c,d;if("object"!=typeof a)throw new Error("Please supply an object of options");if(!a.message)throw new Error("Please specify a message");return a=b.extend({},o,a),a.buttons||(a.buttons={}),c=a.buttons,d=f(c),g(c,function(a,e,f){if(b.isFunction(e)&&(e=c[a]={callback:e}),"object"!==b.type(e))throw new Error("button with key "+a+" must be an object");e.label||(e.label=a),e.className||(e.className=2>=d&&f===d-1?"btn-primary":"btn-default")}),a}function i(a,b){var c=a.length,d={};if(1>c||c>2)throw new Error("Invalid argument length");return 2===c||"string"==typeof a[0]?(d[b[0]]=a[0],d[b[1]]=a[1]):d=a[0],d}function j(a,c,d){return b.extend(!0,{},a,i(c,d))}function k(a,b,c,d){var e={className:"bootbox-"+a,buttons:l.apply(null,b)};return m(j(e,d,c),b)}function l(){for(var a={},b=0,c=arguments.length;c>b;b++){var e=arguments[b],f=e.toLowerCase(),g=e.toUpperCase();a[f]={label:d(g)}}return a}function m(a,b){var d={};return g(b,function(a,b){d[b]=!0}),g(a.buttons,function(a){if(d[a]===c)throw new Error("button key "+a+" is not allowed (options are "+b.join("\n")+")")}),a}var n={dialog:"<div class='bootbox modal' tabindex='-1' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-body'><div class='bootbox-body'></div></div></div></div></div>",header:"<div class='modal-header'><h4 class='modal-title'></h4></div>",footer:"<div class='modal-footer'></div>",closeButton:"<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>",form:"<form class='bootbox-form'></form>",inputs:{text:"<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",textarea:"<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",email:"<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",select:"<select class='bootbox-input bootbox-input-select form-control'></select>",checkbox:"<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",date:"<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",time:"<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",number:"<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",password:"<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"}},o={locale:"en",backdrop:"static",animate:!0,className:null,closeButton:!0,show:!0,container:"body"},p={};p.alert=function(){var a;if(a=k("alert",["ok"],["message","callback"],arguments),a.callback&&!b.isFunction(a.callback))throw new Error("alert requires callback property to be a function when provided");return a.buttons.ok.callback=a.onEscape=function(){return b.isFunction(a.callback)?a.callback.call(this):!0},p.dialog(a)},p.confirm=function(){var a;if(a=k("confirm",["cancel","confirm"],["message","callback"],arguments),a.buttons.cancel.callback=a.onEscape=function(){return a.callback.call(this,!1)},a.buttons.confirm.callback=function(){return a.callback.call(this,!0)},!b.isFunction(a.callback))throw new Error("confirm requires a callback");return p.dialog(a)},p.prompt=function(){var a,d,e,f,h,i,k;if(f=b(n.form),d={className:"bootbox-prompt",buttons:l("cancel","confirm"),value:"",inputType:"text"},a=m(j(d,arguments,["title","callback"]),["cancel","confirm"]),i=a.show===c?!0:a.show,a.message=f,a.buttons.cancel.callback=a.onEscape=function(){return a.callback.call(this,null)},a.buttons.confirm.callback=function(){var c;switch(a.inputType){case"text":case"textarea":case"email":case"select":case"date":case"time":case"number":case"password":c=h.val();break;case"checkbox":var d=h.find("input:checked");c=[],g(d,function(a,d){c.push(b(d).val())})}return a.callback.call(this,c)},a.show=!1,!a.title)throw new Error("prompt requires a title");if(!b.isFunction(a.callback))throw new Error("prompt requires a callback");if(!n.inputs[a.inputType])throw new Error("invalid prompt type");switch(h=b(n.inputs[a.inputType]),a.inputType){case"text":case"textarea":case"email":case"date":case"time":case"number":case"password":h.val(a.value);break;case"select":var o={};if(k=a.inputOptions||[],!b.isArray(k))throw new Error("Please pass an array of input options");if(!k.length)throw new Error("prompt with select requires options");g(k,function(a,d){var e=h;if(d.value===c||d.text===c)throw new Error("given options in wrong format");d.group&&(o[d.group]||(o[d.group]=b("<optgroup/>").attr("label",d.group)),e=o[d.group]),e.append("<option value='"+d.value+"'>"+d.text+"</option>")}),g(o,function(a,b){h.append(b)}),h.val(a.value);break;case"checkbox":var q=b.isArray(a.value)?a.value:[a.value];if(k=a.inputOptions||[],!k.length)throw new Error("prompt with checkbox requires options");if(!k[0].value||!k[0].text)throw new Error("given options in wrong format");h=b("<div/>"),g(k,function(c,d){var e=b(n.inputs[a.inputType]);e.find("input").attr("value",d.value),e.find("label").append(d.text),g(q,function(a,b){b===d.value&&e.find("input").prop("checked",!0)}),h.append(e)})}return a.placeholder&&h.attr("placeholder",a.placeholder),a.pattern&&h.attr("pattern",a.pattern),a.maxlength&&h.attr("maxlength",a.maxlength),f.append(h),f.on("submit",function(a){a.preventDefault(),a.stopPropagation(),e.find(".btn-primary").click()}),e=p.dialog(a),e.off("shown.bs.modal"),e.on("shown.bs.modal",function(){h.focus()}),i===!0&&e.modal("show"),e},p.dialog=function(a){a=h(a);var d=b(n.dialog),f=d.find(".modal-dialog"),i=d.find(".modal-body"),j=a.buttons,k="",l={onEscape:a.onEscape};if(b.fn.modal===c)throw new Error("$.fn.modal is not defined; please double check you have included the Bootstrap JavaScript library. See http://getbootstrap.com/javascript/ for more details.");if(g(j,function(a,b){k+="<button data-bb-handler='"+a+"' type='button' class='btn "+b.className+"'>"+b.label+"</button>",l[a]=b.callback}),i.find(".bootbox-body").html(a.message),a.animate===!0&&d.addClass("fade"),a.className&&d.addClass(a.className),"large"===a.size?f.addClass("modal-lg"):"small"===a.size&&f.addClass("modal-sm"),a.title&&i.before(n.header),a.closeButton){var m=b(n.closeButton);a.title?d.find(".modal-header").prepend(m):m.css("margin-top","-10px").prependTo(i)}return a.title&&d.find(".modal-title").html(a.title),k.length&&(i.after(n.footer),d.find(".modal-footer").html(k)),d.on("hidden.bs.modal",function(a){a.target===this&&d.remove()}),d.on("shown.bs.modal",function(){d.find(".btn-primary:first").focus()}),"static"!==a.backdrop&&d.on("click.dismiss.bs.modal",function(a){d.children(".modal-backdrop").length&&(a.currentTarget=d.children(".modal-backdrop").get(0)),a.target===a.currentTarget&&d.trigger("escape.close.bb")}),d.on("escape.close.bb",function(a){l.onEscape&&e(a,d,l.onEscape)}),d.on("click",".modal-footer button",function(a){var c=b(this).data("bb-handler");e(a,d,l[c])}),d.on("click",".bootbox-close-button",function(a){e(a,d,l.onEscape)}),d.on("keyup",function(a){27===a.which&&d.trigger("escape.close.bb")}),b(a.container).append(d),d.modal({backdrop:a.backdrop?"static":!1,keyboard:!1,show:!1}),a.show&&d.modal("show"),d},p.setDefaults=function(){var a={};2===arguments.length?a[arguments[0]]=arguments[1]:a=arguments[0],b.extend(o,a)},p.hideAll=function(){return b(".bootbox").modal("hide"),p};var q={bg_BG:{OK:"Ок",CANCEL:"Отказ",CONFIRM:"Потвърждавам"},br:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Sim"},cs:{OK:"OK",CANCEL:"Zrušit",CONFIRM:"Potvrdit"},da:{OK:"OK",CANCEL:"Annuller",CONFIRM:"Accepter"},de:{OK:"OK",CANCEL:"Abbrechen",CONFIRM:"Akzeptieren"},el:{OK:"Εντάξει",CANCEL:"Ακύρωση",CONFIRM:"Επιβεβαίωση"},en:{OK:"OK",CANCEL:"Cancel",CONFIRM:"OK"},es:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Aceptar"},et:{OK:"OK",CANCEL:"Katkesta",CONFIRM:"OK"},fa:{OK:"قبول",CANCEL:"لغو",CONFIRM:"تایید"},fi:{OK:"OK",CANCEL:"Peruuta",CONFIRM:"OK"},fr:{OK:"OK",CANCEL:"Annuler",CONFIRM:"D'accord"},he:{OK:"אישור",CANCEL:"ביטול",CONFIRM:"אישור"},hu:{OK:"OK",CANCEL:"Mégsem",CONFIRM:"Megerősít"},hr:{OK:"OK",CANCEL:"Odustani",CONFIRM:"Potvrdi"},id:{OK:"OK",CANCEL:"Batal",CONFIRM:"OK"},it:{OK:"OK",CANCEL:"Annulla",CONFIRM:"Conferma"},ja:{OK:"OK",CANCEL:"キャンセル",CONFIRM:"確認"},lt:{OK:"Gerai",CANCEL:"Atšaukti",CONFIRM:"Patvirtinti"},lv:{OK:"Labi",CANCEL:"Atcelt",CONFIRM:"Apstiprināt"},nl:{OK:"OK",CANCEL:"Annuleren",CONFIRM:"Accepteren"},no:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},pl:{OK:"OK",CANCEL:"Anuluj",CONFIRM:"Potwierdź"},pt:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Confirmar"},ru:{OK:"OK",CANCEL:"Отмена",CONFIRM:"Применить"},sq:{OK:"OK",CANCEL:"Anulo",CONFIRM:"Prano"},sv:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},th:{OK:"ตกลง",CANCEL:"ยกเลิก",CONFIRM:"ยืนยัน"},tr:{OK:"Tamam",CANCEL:"İptal",CONFIRM:"Onayla"},zh_CN:{OK:"OK",CANCEL:"取消",CONFIRM:"确认"},zh_TW:{OK:"OK",CANCEL:"取消",CONFIRM:"確認"}};return p.addLocale=function(a,c){return b.each(["OK","CANCEL","CONFIRM"],function(a,b){if(!c[b])throw new Error("Please supply a translation for '"+b+"'")}),q[a]={OK:c.OK,CANCEL:c.CANCEL,CONFIRM:c.CONFIRM},p},p.removeLocale=function(a){return delete q[a],p},p.setLocale=function(a){return p.setDefaults("locale",a)},p.init=function(c){return a(c||b)},p});

/*! VFM - veno file manager main functions
 * ================
 * @Author  Nicola Franchini
 * @Support <http://www.veno.es>
 * @version 2.6
 * @license Exclusively sold on CodeCanyon: http://bit.ly/veno-file-manager
 */

/* 
 * Close alert message
 */
$(document).on('click', '.closealert', function () {
    $(this).parent().fadeOut();
});

/**
 * Clipbooard
 */
function callClipboards(){
        var clipboardSnippets = new Clipboard('.clipme');
        var timer = window.setTimeout(function() {
            $('.clipme').popover('destroy');
        }, 1000);
        clipboardSnippets.on('success', function(e) {
            window.clearTimeout(timer);

            $('.clipme').popover('show');
            timer = setTimeout(function() {
                $('.clipme').popover('destroy')
            }, 1000);
        });
}

/**
 * Call vid preview 
 */
$(document).on('click', 'a.vid', function(e) {
    e.preventDefault();
    $('.navigall').remove();
    var thislink = $(this).data('link');
    var thislinkencoded = $(this).data('linkencoded');
    var thisname = $(this).data('name');
    var thisID = $(this).parents('.rowa').attr('id');
    var thisExt = $(this).data('ext');

    loadVid(thislink, thislinkencoded, thisname, thisID, thisExt);
});

/**
 * Call image preview 
 */
$(document).on('click', 'a.thumb', function(e) {
    e.preventDefault();
    $('.navigall').remove();
    var thislink = $(this).data('link');
    var thisname = $(this).data('name');
    var user = $(this).data('user');
    // var thisID = $(this).parents('.rowa').attr('id');
    var thispage = 0;
     
    $.ajax({
        type: "POST",
        url: "vfm-admin/ajax/getpagenum.php",
        dataType: 'json',
        data: {
            filename: encodeURI(thisname),
            username: user
        },
        async: false,
        success: function (data) {
            if (data.status == 1) {
                if (data.pageNum == 0)
                    $('a.thumb').data('page', 1);
                if (data.pageNum >0 && data.pageNum <= 5) {
                    $('a.thumb').data('page', data.pageNum);
                }
                if (data.pageNum > 5) {
                $('a.thumb').data('page', 5);
                }  
            } else {
                $('a.thumb').data('page', 1);
                toastr.error('网络错误');
            }
        },
        error: function (error) {
            $('a.thumb').data('page', 1);
            toastr.error('网络错误');
        }
    });
    // $('a.thumb').data('page', 5);

    loadImg(thislink, thisname, thispage);
});

$(document).on('click', 'a.office', function(e) {
    e.preventDefault();
    $('.navigall').remove();
    var thislink = $(this).data('link');
    var thisname = $(this).data('name');
    var user = $(this).data('user');
    // var thisID = $(this).parents('.rowa').attr('id');
    var thispage = 0;

    $.ajax({
        type: "POST",
        url: "vfm-admin/ajax/getpagenum.php",
        dataType: 'json',
        data: {
            filename: encodeURI(thisname),
            username: user
        },
        async: false,
        success: function (data) {
            if (data.status == 1) {
                if (data.pageNum == 0)
                {
                    $('a.office').data('page', 1);
                }
                if (data.pageNum <= 5 && data.pageNum >0){
                $('a.office').data('page', data.pageNum);
				
                }
                if (data.pageNum >5) {
                    $('a.office').data('page', 5);
					console.log(data.pageNum);
                }
            } else {
                $('a.office').data('page', 1);
                toastr.error('网络错误');
            }
        },
        error: function (error) {
            $('a.office').data('page', 1);
            toastr.error('网络错误');
        }
    });
    
    $.ajax({
        type: "POST",
        url: "vfm-admin/ajax/getPreview.php",
        dataType: 'json',
        data: {
            filename: encodeURI(thisname),
            username: user
        },
        async: false,
        success: function (data) {
            if (data.status == 1) {
                if (data.preview == "") {
                    toastr.warning('暂不可预览，请稍后再试');
                }else {
                    $('a.office').data('preview', data.preview);
					
                    loadOffice(thislink, thisname, thispage);
                }
            } else {
                toastr.error('网络错误');
            }
        },
        error: function (error) {
            toastr.error('网络错误');
        }
    });
});

/**
 * Return first item from the end of the gallery
 */
jQuery.fn.firstAfter = function(selector) {
    return this.nextAll(selector).first();
};
jQuery.fn.firstBefore = function(selector) {
    return this.prevAll(selector).first();
};

/**
 * Setup gallery navigation
 */
// function checkNextPrev(currentID){

//     var current = $('#'+currentID);
//     var nextgall = current.firstAfter('.gallindex').find('.vfm-gall');
//     var prevgall = current.firstBefore('.gallindex').find('.vfm-gall');

//     if (nextgall.length > 0){

//         var nextlink = nextgall.data('link');  
//         var nextlinkencoded = nextgall.data('linkencoded');
//         var nextname = nextgall.data('name');
//         var nextID = current.firstAfter('.gallindex').attr('id');

//         if ($('.nextgall').length < 1) {
//             $('.vfm-zoom').append('<a class="nextgall navigall"><span class="fa-stack"><i class="fa fa-angle-right fa-stack-1x fa-inverse"></i></span></a>');
//         }
//         $('.nextgall').data('link', nextlink)
//         $('.nextgall').data('linkencoded', nextlinkencoded)
//         $('.nextgall').data('name', nextname)
//         $('.nextgall').data('id', nextID)
//     } else {
//         $('.nextgall').remove();
//     }

//     if (prevgall.length > 0){

//         var prevlink = prevgall.data('link');  
//         var prevlinkencoded = prevgall.data('linkencoded');
//         var prevname = prevgall.data('name');
//         var prevID = current.firstBefore('.gallindex').attr('id');

//         if ($('.prevgall').length < 1) {
//             $('.vfm-zoom').append('<a class="prevgall navigall"><span class="fa-stack"><i class="fa fa-angle-left fa-stack-1x fa-inverse"></i></span></a>');
//         }
//         $('.prevgall').data('link', prevlink)
//         $('.prevgall').data('linkencoded', prevlinkencoded)
//         $('.prevgall').data('name', prevname)
//         $('.prevgall').data('id', prevID)
//     } else {
//         $('.prevgall').remove();
//     }
// }

/**
 * 判断是否出现上一页、下一页按钮
 */
function checkPage(thislink, thisname, thispage) {
    // 总页数
    var allPage = $('a.thumb').data('page');
    if (thispage > 0) {
        $('.vfm-zoom').append('<a class="prevgall navigall"><span class="fa-stack"><i class="fa fa-angle-left fa-stack-1x fa-inverse"></i></span></a>');
        $('.prevgall').data('link', thislink);
        $('.prevgall').data('name', thisname);
    }
    if (thispage < allPage - 1) {
        $('.vfm-zoom').append('<a class="nextgall navigall"><span class="fa-stack"><i class="fa fa-angle-right fa-stack-1x fa-inverse"></i></span></a>');
        $('.nextgall').data('link', thislink);
        $('.nextgall').data('name', thisname);
    }
}

function checkPageOffice(thislink, thisname, thispage) {
    // 总页数
    var allPage = $('a.office').data('page');
    if (thispage > 0) {
        $('.vfm-zoom').append('<a class="officeprevgall navigall"><span class="fa-stack"><i class="fa fa-angle-left fa-stack-1x fa-inverse"></i></span></a>');
        $('.officeprevgall').data('link', thislink);
        $('.officeprevgall').data('name', thisname);
    }
    if (thispage < allPage - 1) {
        $('.vfm-zoom').append('<a class="officenextgall navigall"><span class="fa-stack"><i class="fa fa-angle-right fa-stack-1x fa-inverse"></i></span></a>');
        $('.officenextgall').data('link', thislink);
        $('.officenextgall').data('name', thisname);
    }
}
/**
 * navigate through image preview gallery
 */
$(document).on('click', 'a.officenextgall', function(e) {
    var thislink = $(this).data('link');
    var thisname = $(this).data('name');
    var thispage = $('a.office').data('thispage') + 1;
    $('.navigall').remove();

    loadOffice(thislink, thisname, thispage);
});

$(document).on('click', 'a.officeprevgall', function(e) {
    var thislink = $(this).data('link');
    var thisname = $(this).data('name');
    var thispage = $('a.office').data('thispage') - 1;
    $('.navigall').remove();

    loadOffice(thislink, thisname, thispage);
});


/**
 * navigate through image preview gallery
 */
$(document).on('click', 'a.nextgall', function(e) {
    var thislink = $(this).data('link');
    var thisname = $(this).data('name');
    var thispage = $('a.thumb').data('thispage') + 1;
    $('.navigall').remove();

    loadImg(thislink, thisname, thispage);
});

$(document).on('click', 'a.prevgall', function(e) {
    var thislink = $(this).data('link');
    var thisname = $(this).data('name');
    var thispage = $('a.thumb').data('thispage') - 1;
    $('.navigall').remove();

    loadImg(thislink, thisname, thispage);
});

/**
* navigate with arrow keys
*/
$(document).keydown(function(e) {
    if(e.keyCode == 39 && $('.nextgall').length > 0) { // right
        $('.nextgall').trigger('click');
    }

    if(e.keyCode == 37 && $('.prevgall').length > 0) { // left
        $('.prevgall').trigger('click');
    }
});

$(document).ready(function(e) {
    $('#zoomview').on('hidden.bs.modal', function () {
       $('.navigall').remove();
    });
});
//不要
$(document).on('change','#shoplist',function (e) {
    var t = $('#shoplist option:selected').val();
    var imgs = ['vfm-admin/images/gongtotu.png','vfm-admin/images/gongtohong.png','vfm-admin/images/gongtoxi.png'];
    $('#gongtotu').attr("src",imgs[t-1]);
    $('#gongtotu').css("display","block");
});

/**
* Rename file and folder 
*/
$(document).on('click', '.rename a', function () {
    var thisname = $(this).data('thisname');
    var thisdir = $(this).data('thisdir');
    var thisext = $(this).data('thisext');
    $('#newname').val(thisname);
    $('#oldname').val(thisname);
    $('#dir').val(thisdir);
    $('#ext').val(thisext);
    $('#modalchangename').modal();
});

/*
*批量下单模块框
*
*/
$(document).on('click','#creatorderlist',function(){
    $.ajax({
        dataType:'json',
        url:'vfm-admin/ajax/getinvitationNumbers.php',
        async:false,
        success:function(data){//qqqqqqq
             setCookie('sharenumbers',data.sharenumbers);
            console.log('success');

        },
        error:function(){
            console.log('error');
        }

    });
    var $html='<div style="color:#aaaaaa">批量打印时默认打印全部页数</div>';
    $('#fileloadinglist').hide();
    getPageNumlist();
    var orderlist =[];
    var r = getCookie('arr');
    var orderlist = JSON.parse(r);

    if (orderlist.length==0) {
        alert("请选择打印文件！");
        $('#modalcreateorderlist').modal('hide');
    }else{

	 $('#shoplist').val(0);
	 $('#original_pricelist').html('0');
     $.ajax({
        type:'POST',
        url:'vfm-admin/ajax/get-Everydayorderpages.php?t='+(new Date).getTime(),
        /*data:{arr:r},*/
        async:false,
        dataType: 'json',
       success:function(data){
            $('#getorderslist').html(data.orders);
            $('#getpageslist').html(data.pages);
            $('#getisfirstorder').val(data.isfirstorder);
            /*console.log(data);*/
            },
        fail:function (data) {
            console.log('error');
        }

     });
    for(var i in orderlist){
        if (orderlist[i].pagenum !=0 && orderlist[i].pagenum !=-1) {
       $html +='<div class ="listfile">'+
       '<div class="input-group">'+
                    '<span class="input-group-addon">文件名</span>'+
                    '<input type="text" name="file['+i+'][name]" class="form-control" placeholder="文件名" value="'+orderlist[i].thisfile+'" readonly required>'+
            '</div>'+
            '<div class="input-group">'+
                '<span class="input-group-addon">份数</span>'+
                '<input type="number"  name="file['+i+'][copies]" class="copies form-control" min="1" placeholder="份数"  value="1" required>'+
                '<span class="input-group-addon">胶装</span>'+
                    '<select class="binding form-control" name="file['+i+'][binding]" >'+
                      '<option value="0">否</option>'+
                      '<option value="1" name="file['+i+'][bind_price]" class="bind_price">是（+ 0 元）'+
                      '</option>'+
                    '</select>'+  
           '</div>'+
            '<div class="input-group">'+
                '<span class="input-group-addon">页数范围</span>'+
                '<input type="number" name="file['+i+'][start]" class="start form-control" placeholder="起始页" min="1" value="1" required readonly>'+
                '<span class="input-group-addon">~</span>'+
                '<input type="number" name="file['+i+'][over]" class="over form-control" placeholder="终止页" value="'+orderlist[i].pagenum+'" required readonly>'+
            '</div>'+
            '<div class="radio">'+
                 '<label class="onepage radio-inline"><input type="radio" class="radiobtn" name="file['+i+'][pagetype]" value="onepage" checked >'+
                        '单面（￥'+
                        '<span name="file['+i+'][onesideprice]" class="onesideprice">0</span>'+
                        '/页）'+
                    '</label>'+
                    '<label class="dualpage radio-inline"><input type="radio" class="radiobtn" name="file['+i+'][pagetype]" value="dualpage" >'+
                        '双面（￥'+
                        '<span name="file['+i+'][bothsideprice]" class="bothsideprice">0</span>'+
                        '/页）'+
                    '</label></div>'; 
            if (orderlist[i].ext == 'ppt') {
                $html+='<div class="radio"><label class="pptone radio-inline"><input type="radio" class="radiobtn" name="file['+i+'][ppttype]" value="1" checked>'+
                    '<img src="vfm-admin/images/ppt1.png" style="width:18px;">'+
                '</label>'+
                 '<label class="pptthree radio-inline"><input type="radio" class="radiobtn" name="file['+i+'][ppttype]" value="3" >'+
                    '<img src="vfm-admin/images/ppt3.png" style="width:18px;" >'+
                   
                '</label>'+
                '<label class="pptfour radio-inline"><input type="radio" class="radiobtn" name="file['+i+'][ppttype]" value="4" >'+
                    '<img src="vfm-admin/images/ppt4.png" style="width:18px;">'+           
                '</label>'+
                '<label class="pptsix radio-inline"><input type="radio" class="radiobtn" name="file['+i+'][ppttype]" value="6" >'+
                    '<img src="vfm-admin/images/ppt6.png"style="width:18px; ">'+
                '</label> 提示：选择模板';
            }
            $html+=
             '</div><br>'+
            '<input type="hidden" name="file['+i+'][realfilename]" class="realfilename" value="'+orderlist[i].thisfile+'" readonly>'+
            '<input type="hidden" name="file['+i+'][price]" readonly> </input>'+
            '<input type="hidden" name="file['+i+'][ext]" class="fileext" value="'+orderlist[i].ext+'" readonly>'+
           '</div>';           
     }
 }
    $html+='';
    $('#filelist').html($html);
    $('#modalcreateorderlist').modal();
     showPricelist();
	 allPricelist();
    
    }
});

// 关闭创建批量下单模态框触发的事件
$(document).on('hidden.bs.modal', '#modalcreateorderlist', function () {
    // 如果clock已定义，则清除setInterval
    if (typeof clock != "undefined" ? true : false) {
        window.clearInterval(clock);
        delete clock;
    }
    delCookie('arr');
});

/**
*批量下单价格显示
*
**///22222222
function showPricelist() {
    var shops = $.parseJSON($('#shopslist').val());  
    var r = getCookie('arr');
    var arr = JSON.parse(r);
    var i = arr.length;
   /* $('.listfile').each(function(){*/
    
         var shop = $('#shoplist').val();
        /*console.log(shop);*/
        if (shop == 0) {           
            for(var j = 0; j<i; j++){  
                    $("option[name='file["+j+"][bind_price]']").html('是（+￥0)');
                    /// 胶装价格
                    $("span[name='file["+j+"][onesideprice]']").html(0);  // 单页价格
                    $("span[name='file["+j+"][bothsideprice]']").html(0); // 双页价格
            }
            $('#isDeliverylist').hide();
            $('#delivery_pricelist').html('是（+￥0）');
        } else {
            shop = shop - 1;       
            for(var j = 0; j<i; j++){
                    $("option[name='file["+j+"][bind_price]']").html('是（+￥' + shops[shop].bind_price + '）');
                    /// 胶装价格
                    $("span[name='file["+j+"][onesideprice]']").html(shops[shop].onesideprice);  // 单页价格
                    $("span[name='file["+j+"][bothsideprice]']").html(shops[shop].bothsideprice); // 双页价格
            }
            if (shops[shop].deliveryprice == 0) {
                $('#isDeliverylist').hide();
            }else{
                $('#isDeliverylist').show();
                $('#delivery_pricelist').html('是（+￥ '+shops[shop].deliveryprice+' ）如果总价大于￥5，免配送费！(配送时间仅限中午晚上)');
            }
            
        }
    }



/*
*批量订单获取页数
*/
var getPageNumlist = function () {
    var list = orderSelecta();//获取选中的文件数组
    /*$('#fileloadinglist').show();*/
    for(var j = 0 ,len = list.length; j<len; j++){
        $.ajax({
        type: "POST",
        url: "vfm-admin/ajax/getpagenum.php",
        dataType: 'json',
        async:false,
        data: {
            filename: encodeURI(list[j].thisfile),
            username: list[j].username
        },
        success: function (data) {
            if (data.status == 1) {
                if (data.pageNum != 0 && data.pageNum != -1) {
                    // 存在clock，清除setInterval
                    if (typeof clock != "undefined" ? true : false && i!=0) {
                        window.clearInterval(clock);
                        delete clock;
                    }
                   /* $('#fileloadinglist').hide();*/
                    $('#orderDivlist').show();
                } else if (data.pageNum == -1) {
                    /*toastr.error('读取文件出错，请检查内容是否正确');*/
                    delete clock;
                    /* $('#fileloadinglist').hide();*/
           /* $('#orderDivlist').hide();*/
                }
                else if (data.pageNum == 0) {
                   /* toastr.error('正在解析文件，请稍后再试');*/
                    delete clock;
                   /* $('#fileloadinglist').hide();*/
                   /* $('#orderDivlist').hide();*/
                     }
                else if (typeof clock != "undefined" ? false : true)
                    // 页数为0，且clock未定义，则使用setInterval+ajax进行轮询
                   {
                    clock = window.setInterval('getPageNum("' + thisfile + '", "' + username + '")', 1500);
                }
                $('#page').val(data.pageNum);

               
            } else {    
                toastr.error('查询失败，请稍后再试');
            }
        },
        error: function (error) {
            toastr.error('网络错误');
            delete clock;
            $('#fileloadinglist').hide();
            $('#orderDivlist').hide();
        }
    });
        
       /* list[j]['pagenum'] = $('#page').val();*/
       /* console.log($('#page').val());
        console.log($list[$j]['pagenum']);*/
        list[j].pagenum=$('#page').val();

    }
    $('#fileloadinglist').hide();
    var orders = canbeordered(list);//返回可打印的文件数组
    var str =JSON.stringify(orders);
    setCookie('arr',str);
 //*mulorder
}
function setCookie(name, value, days) {
        var exp = new Date();//qqqqqq
       var r=  exp.setTime(exp.getTime() + days*1*1*1*1);
        console.log(r);
        document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

//读cookie
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
    return unescape(arr[2]);
    else
    return null;
}
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
    document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
var canbeordered=function(arr){
    var ordered = [];
    var j = 0;
    var html='';
    for (var i = 0; i < arr.length; i++) {
        flag=0;
        if (arr[i].pagenum !=0 &&arr[i].pagenum !=-1) {
             ordered[j]=arr[i];
             j++;
            
        } else{           
            html+=arr[i].thisfile+'；';
        }
    }
    if (html != '') {
        var html1='无法打印的文件：';
        $('#warnning_textlist').html(html1+html);
    }
   return ordered;
}
/*批量下单价格计算*/
function allPricelist() {
    var r = getCookie('arr');
    var arr = JSON.parse(r);
    var i = arr.length;
    var shop = $('#shoplist').val();
    if (shop == 0) {
        $('#all_pricelist').html(0);
    } else {
        shop = shop - 1;
        var allprice = 0;
            for(var j =0; j<i;j++){
                var copies = $("#modalcreateorderlist input[name='file["+j+"][copies]']").val();
                var over = $("#modalcreateorderlist input[name='file["+j+"][over]']").val();
                var binding =$("#modalcreateorderlist select[name='file["+j+"][binding]']").val();
                var shops = $.parseJSON($('#shopslist').val());
                var pagetype = $("#modalcreateorderlist input:radio[name='file["+j+"][pagetype]']:checked").val();
                var page_price = pagetype == 'onepage'? shops[shop]['onesideprice']:shops[shop]['bothsideprice'];
                if (arr[j].ext=='ppt') {//ppt打印时 ppt页数除以模板得纸张页数

                    var ppttype = $("#modalcreateorderlist input[name='file["+j+"][ppttype]']:checked").val();
                    var page_num = Math.ceil(over/ppttype);
                }else{
                    var page_num = over;
                } 
                var bind_price = parseInt(shops[shop].bind_price);
                var all_price = page_num * page_price;
                if (binding == 1) all_price = all_price + bind_price;
                all_price *= copies;
                allprice+=all_price;
            }
            var this_off_pages=0;//本次优惠的页数
            var off_price = 0;//优惠金额
            var firstorderpages  = 10;//首单优惠页数
            $.ajax({
            type:'POST',
            url:'vfm-admin/ajax/getifinvited.php',
            async:false,
            dataType:'json',
            success:function(data){
                if (data.issharenumbers != data.sharenumbers) {
                     setCookie('issharenumbers',data.issharenumbers);
                     if (parseFloat($('#getorderslist').text())<3 && parseFloat($('#getpageslist').text())<30) {
                        var page_off = 30 - parseFloat($('#getpageslist').text());//剩余可优惠的页数
                        for(var j=0;j<i;j++){
                            if (page_off>0) {
                                var copies = $("#modalcreateorderlist input[name='file["+j+"][copies]']").val();
                                var over = $("#modalcreateorderlist input[name='file["+j+"][over]']").val();
                                var shops = $.parseJSON($('#shopslist').val());
                                var pagetype = $("#modalcreateorderlist input:radio[name='file["+j+"][pagetype]']:checked").val();
                                if (pagetype == 'onepage') {
                                    var page_price = shops[shop]['onesideprice'];
                                }
                                if (pagetype == 'dualpage') {
                                    var page_price = shops[shop]['bothsideprice'];
                                }
                                if (arr[j].ext=='ppt') {
                                  
                                    var page_num = Math.ceil(over/ppttype);
                                }else{
                                    var page_num = over;
                                }
                                console.log(page_num+'page_num');
                                if (1- parseFloat(shops[shop]['discount'])) {
                                    if (copies*page_num<=page_off) {
                                        //首单前十页免费
                                        if ($('#getisfirstorder').val()==1 && firstorderpages>0) {
                                            if (copies*page_num<firstorderpages) {
                                                off_price +=copies*page_num*page_price;
                                                this_off_pages += copies*page_num;
                                                firstorderpages -= copies*page_num;
                                                page_off -= copies*page_num;
                                            }else{
                                                off_price +=firstorderpages*page_price;
                                                off_price +=(copies*page_num - firstorderpages)*page_price*(1- parseFloat(shops[shop]['discount']));
                                                this_off_pages += copies*page_num;
                                                page_off -= copies*page_num;
                                                firstorderpages = 0;
                                            }
                                            
                                        }else{
                                            off_price += copies*page_num*page_price*(1- parseFloat(shops[shop]['discount']));
                                            this_off_pages +=copies*page_num;
                                            page_off -=copies*page_num;
                                        }
                                    }else{
                                        off_price += page_off*page_price*(1- parseFloat(shops[shop]['discount']));  
                                        this_off_pages += page_off;
                                        page_off=0;
                                    }
                                }
                            }else{
                                break;
                            }
                        }
                        off_price = Math.floor(off_price*100)/100;//取整
                        if (off_price == 0) {
                            this_off_pages = 0;
                        }
                    }

                }
                
            },
            error:function(data){
                console.log('error');
                console.log(data);
            }

        });
           
		 //最后总价
            var last_price = allprice - off_price;
             //原价
            if ($('#deliverylist').val() == 1) {
                if (allprice>=5) {
                    off_price += parseFloat(shops[shop].deliveryprice);
                }else{
                    last_price += parseFloat(shops[shop].deliveryprice);
                }
                allprice += parseFloat(shops[shop].deliveryprice);
            }
            //如果减免后支付为0则设置为￥0.01
            if (last_price == 0 ) {
                last_price = 0.01;
                off_price -=0.01;
            }
            $('#original_pricelist').html(allprice.toFixed(3));//输出原价
            $('#input_off_pricelist').val(off_price.toFixed(3));//保存打印纸张的优惠金额
          
             //设置

            $('#off_pagenumlist').val(this_off_pages);
            $('#off_pricelist').html(off_price.toFixed(3));//输出优惠价格

            $('#all_pricelist').html(last_price.toFixed(3));//输出最后价格
    }  
}
//批量下单胶状改变
$(document).on('change', '#modalcreateorderlist .binding', function(event) {
    allPricelist();
});
//批量下单店铺选项改变
$(document).on('change', '#shoplist', function(event) {
    showPricelist();
    /*console.log($('#shoplist').val()+'23546');*/
    allPricelist();
}); 
//批量下单打印份数改变
$(document).on('change', '#modalcreateorderlist .copies', function(event) {
    allPricelist();
});
//批量下单单双页改变
$(document).on('change', '.radiobtn', function(event) {
    allPricelist();
});
//
//配送费变动
$(document).on('change', '#deliverylist', function(event) {
    allPricelist();
    if ($(this).val()==1) {
        $('#displaylist').css('display','block');
    }else{
         $('#displaylist').css('display','none');
    }
});

/**
 * 订单模态框
 */
$(document).on('click', '.order a', function () {
    var thisfile = $(this).data('thisfile');
    var filelink = $(this).data('filelink');

    var thisext = $(this).data('thisext');
    $.ajax({
        dataType:'json',
        url:'vfm-admin/ajax/getinvitationNumbers.php',
        async:false,
        success:function(data){
            setCookie('sharenumbers',data.sharenumbers);
            console.log('success');
        },
        error:function(){
            console.log('error');
        }

    });
     if (thisext == 'ppt') {
        html='';
                html+='<div class="radio"><label class="pptone radio-inline"><input type="radio" class="radiobtn" name="ppttype" value="1" checked>'+
                    '<img src="vfm-admin/images/ppt1.png" style="width:18px;">'+
                '</label>'+
                 '<label class="pptthree radio-inline"><input type="radio" class="radiobtn" name="ppttype" value="3" >'+
                    '<img src="vfm-admin/images/ppt3.png" style="width:18px;" >'+
                   
                '</label>'+
                '<label class="pptfour radio-inline"><input type="radio" class="radiobtn" name="ppttype" value="4" >'+
                    '<img src="vfm-admin/images/ppt4.png" style="width:18px;">'+           
                '</label>'+
                '<label class="pptsix radio-inline"><input type="radio" class="radiobtn" name="ppttype" value="6" >'+
                    '<img src="vfm-admin/images/ppt6.png"style="width:18px; ">'+
                '</label> 提示：选择模板'+
                '<input type="hidden" name="fileext" id="fileext" value="'+thisext+'" readonly>';
                $('#insertOrder').html(html);
            }
    $('#fileloading').html('文件解析中...');
    $('#orderDiv').hide();
    $('#fileloading').show();
     $('#shop').val(0);
    $('#original_price').html('0');
    $('#off_price').html('0');
    var username = $('#username').val();
    /*console.log(username);*/
    i = 0;
    getPageNum(thisfile, username);
    /*console.log(thisext);*/
    $.ajax({
        type:'POST',
        url:'vfm-admin/ajax/get-Everydayorderpages.php?t='+(new Date).getTime(),
        /*data:{arr:r},*/
        async:false,
        dataType: 'json',
       success:function(data){
            $('#getorders').html(data.orders);
            $('#getpages').html(data.pages);
            /*console.log(data);*/
            },
        fail:function (data) {
            console.log('error');
        }

           });
    if (thisext != "pdf") {
        $('#filetype_tips').html('<i>*提示：转换为pdf文档效果会更好</i>');
    } else {
        $('#filetype_tips').html('');
    }
    $('#realfilename').val(thisfile);
    $('#filename').val(thisfile);
    $('#copies').val(1);
    $('#start').val(1);
    $('#over').val('');
    // $('#over').val(maxpage);
    // $('#start').attr('max', maxpage);
    // $('#over').attr('max', maxpage);
    $('#shop').val(0);
    $('#binding').val(0);
    $('#dualpage').removeAttr('checked');
    $('#filelink').val(filelink); 
    showPrice();
    allPrice();
    $('#modalcreateorder').modal();
});


// 关闭创建订单模态框触发的事件
$(document).on('hidden.bs.modal', '#modalcreateorder', function () {
    // 如果clock已定义，则清除setInterval
    if (typeof clock != "undefined" ? true : false) {
        window.clearInterval(clock);
        delete clock;
    }
});

/**
 * ajax获取文件页数
 * @param  {String} thisfile 文件名
 * @param  {String} username 用户名
 * @return {int}          文件页数
 */
var getPageNum = function (thisfile, username,thisext) {
    // i++;
    // // 请求5次，提示错误
    // if (i >= 5) {
        // window.clearInterval(clock);
        // setTimeout(function () {
            // delete clock;
            // $('#fileloading').hide();
            // toastr.warning('获取文件页数失败，请自行填写');
            // $('#orderDiv').show();
            // $('#over').val("");
        // }, 1500);

    // }
    $.ajax({
        type: "POST",
        url: "vfm-admin/ajax/getpagenum.php",
        dataType: 'json',
        data: {
            filename: encodeURI(thisfile),
            username: username
        },
        success: function (data) {
            if (data.status == 1) {
                if (data.pageNum != 0 && data.pageNum != -1) {
                    // 存在clock，清除setInterval
                    if (typeof clock != "undefined" ? true : false && i!=0) {
                        window.clearInterval(clock);
                        delete clock;
                    }
                    $('#orderDiv').show();
                    $('#fileloading').hide();
                    if (thisext == 'pdf') {
                        $('#start').val('1');
                         $('#over').val( data.pageNum);
                       /* 
                        
                        $('#start').css('color','#aaa');
                        $('#over').val(data.pageNum);
                        
                        $('#over').removeAttr('min');
                        $('#over').attr('min', data.pageNum);
                        $('#over').css('color','#aaa');*/
                    }
                    else{
                       $('#start').val('1');
                         $('#over').val( data.pageNum);
                    }
                    warning();
                    allPrice();
                } else if (data.pageNum == -1) {
                    toastr.error('读取文件出错，请检查内容是否正确');
                    delete clock;
                    $('#fileloading').hide();
                    $('#modalcreateorder').modal('hide');
                }
				else if (data.pageNum == 0) {
                    toastr.error('正在解析文件，请稍后再试');
                    delete clock;
                    $('#fileloading').hide();
                    $('#modalcreateorder').modal('hide');
                }


				else if (typeof clock != "undefined" ? false : true)
                    // 页数为0，且clock未定义，则使用setInterval+ajax进行轮询
                    clock = window.setInterval('getPageNum("' + thisfile + '", "' + username + '")', 1500);
            } else {
                toastr.error('查询失败，请稍后再试');
            }
        },
        error: function (error) {
            toastr.error('网络错误');
            delete clock;
            $('#fileloading').hide();
            $('#modalcreateorder').modal('hide');
        }
    });
}

// 打印份数的值改变
$(document).on('change', '#copies', function(event) {
    allPrice();
});

// 开始页改变
$(document).on('change', '#start', function(event) {
    warning();
    allPrice();
});

// 结束页改变
$(document).on('change', '#over', function(event) {
    $('#start').attr('max', $('#over').val());
    warning();
    allPrice();
});

// 胶装选项改变
$(document).on('change', '#binding', function(event) {
    allPrice();
});

// 店铺选项改变
$(document).on('change', '#shop', function(event) {
    showPrice();
    allPrice();
}); 

// 单双面改变
$(document).on('change', '.radio', function(event) {
    allPrice();
});

//配送费变动
$(document).on('change', '#delivery', function(event) {
    allPrice();

    if ($(this).val()==1) {
        $('#display').css('display','block');
    }else{
         $('#display').css('display','none');
    }
});


/**
 * 判断表单提交结果是否错误
 */
function warning() {
    if (parseFloat($('#start').val()) > parseFloat($('#over').val())) {
        $('#show_price').hide();
        $('#warnning_text').html("<i>*错误：起始页应小于终止页</i>");
    } else {
        $('#show_price').show();
        $('#warnning_text').html("");
    }
}


/**
 * 显示总价
 */
function allPrice() {
	var shop = $('#shop').val();
	if (shop == 0) {
		$('#all_price').html(0);
	} else {
		shop = shop - 1;
		var copies = $('#copies').val();
		var start = $('#start').val();
		var over = $('#over').val();

		var binding = $('#binding').val();
		var shops = $.parseJSON($('#shops').val());
		var pagetype = $('input:radio[name="pagetype"]:checked').val();
        var ppttype  =$('input:radio[name="ppttype"]:checked').val();
        console.log(ppttype);
        var ext = $('#fileext').val();
        if (ext  == 'ppt') {
            var page_num  = Math.ceil((over - start+1)/ppttype);
        }else{
            var page_num =over - start +1 ;
        }
		
		if (pagetype == 'onepage') {
			var page_price = shops[shop]['onesideprice'];
		}  else {
			var page_price = shops[shop]['bothsideprice'];
			//page_num = page_num%2 == 0 ?
			//	 page_num/2 :
			//	 parseInt(page_num/2) + 1; 
		}
		
		var bind_price = parseInt(shops[shop].bind_price);
		var all_price = page_num * page_price;
		if (binding == 1) all_price = all_price + bind_price;
		all_price *= copies;
        var this_off_pages=0;//本次优惠的页数
        var off_price = 0;//本次优惠价格

         $.ajax({
        type:'POST',
        url:'vfm-admin/ajax/getifinvited.php',
        async:false,
        dataType:'json',
        success:function(data){
            if (data.issharenumbers != data.sharenumbers) {
                     setCookie('issharenumbers',data.issharenumbers);
                       if (parseFloat($('#getorders').text())<3 && parseFloat($('#getpages').text())<30) {
                    var page_off = 30 - parseFloat($('#getpages').text());//剩余可优惠的页数
                       if ((1 - parseFloat(shops[shop].discount))>0) {
                            if (page_off>page_num*copies) {
                               off_price = page_num*page_price*copies*(1 - parseFloat(shops[shop].discount));
                               this_off_pages =page_num*copies;
                               //console.log(page_num);
                               //console.log(page_price);
                              // console.log((1 - parseFloat(shops[shop].discount)));
                               page_off-=page_num*copies;
                           }else{
                                off_price = page_off*page_price*(1 - parseFloat(shops[shop].discount));
                                this_off_pages = page_off;
                                page_off = 0;
                           }
                           //console.log(off_price);
                       }
                       
                        off_price = Math.floor(off_price*100)/100;//取整
                        if (off_price == 0) {
                            this_off_pages = 0;
                        }

                     }
                }
             },
            error:function(){
                console.log('error');
            }
        });
           
         //最后总价
            var last_price = all_price - off_price;
        //原价
            if ($('#delivery').val() == 1) {
                if (all_price>=10) {
                    off_price += parseFloat(shops[shop].deliveryprice);
                }else{
                    last_price += parseFloat(shops[shop].deliveryprice);
                }
                all_price += parseFloat(shops[shop].deliveryprice);
            }
            $('#original_price').html(all_price.toFixed(3));//输出原价
            $('#input_off_price').val(off_price.toFixed(3));//保存打印纸张的优惠金额
          
             //设置
            $('#off_pagenum').val(this_off_pages);
            $('#off_price').html(off_price.toFixed(3));//输出优惠价格
            
            $('#all_price').html(last_price.toFixed(3));//输出最后价格
	}
}


/**
 * 显示、刷新胶装价格以及单双页价格
 */
function showPrice() {
    var shops = $.parseJSON($('#shops').val());
    var shop = $('#shop').val();
	if (shop == 0) {
		$('#bind_price').html('是（+￥0）'); /// 胶装价格
		$('#onesideprice').html(0);  // 单页价格
		$('#bothsideprice').html(0); // 双页价格
        $('#isDelivery').hide();//配送服务隐藏
        $('#delivery_price').html('是（+￥0）');
    } else {
        shop = shop - 1;
        $('#bind_price').html('是（+￥' + shops[shop].bind_price + '）'); /// 胶装价格
        $('#onesideprice').html(shops[shop].onesideprice);  // 单页价格
        $('#bothsideprice').html(shops[shop].bothsideprice); // 双页价格
        if (shops[shop].deliveryprice == 0) {
            $('#isDelivery').hide();
        }else{
            $('#isDelivery').show();
            $('#delivery_price').html('是（+￥ '+shops[shop].deliveryprice+' ）如果总价大于￥10，免配送费！(配送时间仅限中午晚上)');
        }
	}
}


/**
 * 点击分享事件
 */
$(document).on('click', '.share a', function () {

    $('#modalshare').modal();
    var filename = $(this).data('filename');
    var username = $(this).data('username'); 
	$('#getfile').val(filename);
    $('#getuser').val(username);	
});
/*
*确认分享
*/ $(document).on('submit','#isshare',function(){
    var shareschool = encodeURI($('#shareschool').val());
    var sharemajor = encodeURI($('#sharemajor').val());
    var filename = $('#getfile').val();
    var username = $('#getuser').val();
    $('#isshare').data('success', false);    
    $.ajax({
        cache: false,
        url: "vfm-admin/ajax/sharefile.php",
        type: "POST",
        data: {
            filename: filename,
            username: username,
            shareschool:shareschool,
            sharemajor:sharemajor,
            },     
    })
        .done(function(msg){
            if (msg == -1) {
                $('#modalshare').modal('hide');
                toastr.error('该文件内容错误,请稍后再试...');
                console.log(msg);
                
                return false;
              
            }else if(msg == 0){

                $('#modalshare').modal('hide');
                toastr.warning('文件正在解析,请稍后再试...');
                console.log(msg);
                
                return false;
            }else if (msg == 1) {
                $('#isshare').data('success', true);
                
                toastr.success('分享成功');
                $('#modalshare').modal('hide');

            }
       });
        if ($('#isshare').data('success',false)) {
           
            return false;
        }
    });

$(document).on('click','.sharefiles',function(){
  
    var keyword = encodeURI($(this).children('input').val());
    $.ajax({
        cache: false,
        url: "vfm-admin/ajax/loadsharefile.php",
        type: "POST",
        data: {
            keyword:keyword,
            },     
            dataType:"json",
            async: false,
            success:function(data){
                 console.log(data);
                var html ='<table class="table table-striped">'+
                            '<thead>'+
                            '<tr>'+
                                '<th>编号</th>'+
                                '<th>文件名</th>'+
                                '<th>预览</th>'+
                                '<th>上传时间</th>'+
                                '<th>打印</th>'+
                            '</tr>'+   
                            '</thead>'+
                            '<tbody id="filebody">'+      
                            '</tbody>';
                if (data.status==1) {
                    for (var i = 0; i < data['data'].length; i++) {
                        var imgdata = 'data-ext="' + data['data'][i].ext + '"';
                        imgdata += ' data-name="' + data['data'][i].filename + '"';
                        imgdata += ' data-user="'+data['data'][i].username + '"';
                        imgdata += ' data-link="'+data.link+'/'+data['data'][i].username+'/'+encodeURI(data['data'][i].filename)+ '"';
                        if (data['data'][i].ext == "pdf") 
                            imgdata += ' class="thumb vfm-gall"';
                        else if (data['data'][i].ext == 'docx' ||
                            data['data'][i].ext == 'doc'||
                            data['data'][i].ext == 'ppt'||
                            data['data'][i].ext == 'pptx'||
                            data['data'][i].ext == 'xls'||
                            data['data'][i].ext == 'xlsx')
                            imgdata += ' class="office vfm-gall"';
                        html+='<tr><td>'+(i+1)+'</td>'+
                        '<td>'+decodeURI(data['data'][i].filename)+'</td>'+
                        '<td><a href="javascript:void(0);" '+imgdata+'>预览'+'</a></td>'+

                        '<td>'+data['data'][i].time+'</td>'+
                        '<td><a href="javascript:void(0);" id="createord" data-thisfile="'+ decodeURI(data['data'][i].filename) +
                         '" data-thisext="'+data['data'][i].ext+'" data-username="'+
                         data['data'][i].username+'">打印</a></td>'+
                        '</tr>';
                    }
                    $('#searched').html(html);
                }
               else{
                $('#searched').html('<div class="text-center">没有搜索到文件</div>');
               }
            },
            error:function(){
                console.log('error');
            }
        });
});
//搜索分享文件
$(document).on('click','#search_submit',function(){
    var searchschool = encodeURI($('#searchschool option:selected').val());
    var searchmajor = encodeURI($('#searchmajor option:selected').val());
    var keyword = encodeURI($('#keyword').val().trim());
    console.log(searchschool);
    console.log(searchmajor);
    console.log(keyword);
    $.ajax({
        cache: false,
        url: "vfm-admin/ajax/searchsharedfile.php",
        type: "POST",
        data: {
            searchschool:searchschool,
            searchmajor:searchmajor,
            keyword:keyword,
            },     
            dataType:"json",
            async: false,
            success:function(data){
                 console.log(data);
                var html ='<table class="table table-striped">'+
                            '<thead>'+
                            '<tr>'+
                                '<th>编号</th>'+
                                '<th>文件名</th>'+
                                '<th>预览</th>'+
                                '<th>上传时间</th>'+
                                '<th>打印</th>'+
                            '</tr>'+   
                            '</thead>'+
                            '<tbody id="filebody">'+      
                            '</tbody>';
                if (data.status==1) {
                    for (var i = 0; i < data['data'].length; i++) {
                        var imgdata = 'data-ext="' + data['data'][i].ext + '"';
                        imgdata += ' data-name="' + data['data'][i].filename + '"';
                        imgdata += ' data-user="'+data['data'][i].username + '"';
                        imgdata += ' data-link="'+data.link+'/'+data['data'][i].username+'/'+encodeURI(data['data'][i].filename)+ '"';
                        if (data['data'][i].ext == "pdf") 
                            imgdata += ' class="thumb vfm-gall"';
                        else if (data['data'][i].ext == 'docx' ||
                            data['data'][i].ext == 'doc'||
                            data['data'][i].ext == 'ppt'||
                            data['data'][i].ext == 'pptx'||
                            data['data'][i].ext == 'xls'||
                            data['data'][i].ext == 'xlsx')
                            imgdata += ' class="office vfm-gall"';
                        html+='<tr><td>'+(i+1)+'</td>'+
                        '<td>'+decodeURI(data['data'][i].filename)+'</td>'+
                        '<td><a href="javascript:void(0);" '+imgdata+'>预览'+'</a></td>'+

                        '<td>'+data['data'][i].time+'</td>'+
                        '<td><a href="javascript:void(0);" id="createord" data-thisfile="'+ decodeURI(data['data'][i].filename) +
                         '" data-thisext="'+data['data'][i].ext+'" data-username="'+
                         data['data'][i].username+'">打印</a></td>'+
                        '</tr>';
                    }
                    $('#searched').html(html);
                }
               else{
                $('#searched').html('<div class="text-center">没有搜索到文件</div>');
               }
            },
            error:function(){
                console.log('error');
            }
        });
});

//我要接单
$(document).on('click','#wantlist',function(){
    $('#modalacceptlist').show();
    $('#modalacceptlist').modal();
});
$(document).on('click','#acceptlistsuccess',function(){
$('#modalacceptlist').modal('hide');
     toastr.success('接单成功！赶快去取件吧！');

});
$(document).on('click', '#createord', function () {
    var thisfile = $(this).data('thisfile');
    // var filelink = $(this).data('filelink');
    var thisext = $(this).data('thisext');
    var username = $(this).data('username');
    $('#fileloading').html('文件解析中...');
    $('#orderDiv').hide();
    $('#fileloading').show();

    i = 0;
    getPageNum(thisfile, username);
    if (thisext != "pdf") {
        $('#filetype_tips').html('<i>*提示：转换为pdf文档效果会更好</i>');
    } else {
        $('#filetype_tips').html('');
    }
    $('#realfilename').val(thisfile);
    $('#filename').val(thisfile);
    $('#copies').val(1);
    $('#start').val(1);
    $('#over').val('');
    // $('#over').val(maxpage);
    // $('#start').attr('max', maxpage);
    // $('#over').attr('max', maxpage);
    $('#shop').val(0);
    $('#binding').val(0);
    $('#dualpage').removeAttr('checked');
    // $('#filelink').val(filelink); 
    showPrice();
    allPrice();
    $('#modalcreateorder').modal();
});

$(document).on('submit', '#orderForm', function () {
    if (comfirm("是否去邀请好友？可享优惠")) {
        return false;
    }
	$shop = $('#shop').val();
	if ($shop == 0) {
		toastr.error('请选择打印店');
		return false;
	}
});

$(document).on('submit','#orderlistForm',function(){
   if (comfirm("是否去邀请好友？可享优惠")) {
        return false;
    }
    $shoplist = $('#shoplist').val();
    $deliverylist = $('#deliverylist').val();
    $deliveryaddrelist = $('#deliveryaddrelist').val();
    if ($shoplist == 0) {
        toastr.error('请选择打印店');
        return false;
    }
    if ($deliverylist != 0) {
        if ($deliveryaddrelist == 0) {
            toastr.warning('请选择配送地址');
            return false;
        }
    }
});
/** 
* User panel 
*/
$(document).on('click', '.edituser', function () {

    var thisname = $(this).data('thisname');
    var thisdir = $(this).data('thisdir');
    var thisext = $(this).data('thisext');

    $('#newname').val(thisname);
    $('#oldname').val(thisname);

    $('#dir').val(thisdir);
    $('#ext').val(thisext);
});

/**
* password confirm
*/
$('#usrForm').submit(function(e){
    if($('#oldp').val().length < 1) {
        $('#oldp').focus();
        e.preventDefault();
    }
    if($('#newp').val() != $('#checknewp').val()) {
        $('#checknewp').focus();
        e.preventDefault();
    }
    if ($('#isStudent option:selected').val() == 0) {
        $('#isStudent').focus();
        
        e.preventDefault();
    }
});

/**
* password reset 
*/
$('#rpForm').submit(function(e){
    if ($('#rep').val().length < 1) {
        $('#rep').focus();
        e.preventDefault();
    }
    if ($('#rep').val() != $('#repconf').val()) {
        $('#repconf').focus();
        e.preventDefault();
    }
});

/**
* send link to reset password 
*/
$(document).on('keyup keypress', '#sendpwd', function(e){
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
});

$(document).on('submit', '#sendpwd', function (event) {
    event.preventDefault();
    var serialize = $(this).serialize();
    var time = (new Date).getTime();
    $('.mailpreload').fadeIn(function(){
        $.ajax({
            type: "POST",
            url: "vfm-admin/ajax/sendpwd.php",
            data: serialize
            })
            .done(function( msg ) {
                $('.sendresponse').html(msg).fadeIn();
                $('.mailpreload').fadeOut();
                $('#captcha').attr('src', 'vfm-admin/captcha.php?' + time);
                $('#sendpwd .panel-body input').val('');
            })
            .fail(function() {
                $('.mailpreload').fadeOut();
                $('.sendresponse').html('<div class=\"alert alert-danger\">Error connecting: ajax/sendpwd</div>').fadeIn();
                $('#captcha').attr('src', 'vfm-admin/captcha.php?' + time);
        });
    });
});

/**
* add mail recipients (file sharing) 
*/
$(document).on('click', '.shownext', function () {
    var $lastinput = $(this).parent().prev().find('.form-group:last-child .addest');

    if ($lastinput.val().length < 5) {
        $lastinput.focus();
    } else {
        var $newdest, $inputgroup, $addon, $input;
        
        $input = $('<input name="send_cc[]" type="email" class="form-control addest">');
        $addon = $('<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>');
        $inputgroup = $('<div class="input-group"></div>').append($addon).append($input);
        $newdest = $('<div class="form-group bcc-address"></div>').append($inputgroup);

        $('.wrap-dest').append($newdest);
    }
});

/**
* slide fade mail form
*/
$.fn.slideFadeToggle = function(speed, easing, callback) {
    return this.animate({
        opacity: 'toggle',
        height: 'toggle'
    }, speed, easing, callback);
};

$(document).on('click', '.openmail', function () {
    $('#sendfiles').slideFadeToggle();
});

/**
* create a random string
*/
function randomstring() 
{
    var text = '';
    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i=0; i < 8; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

/**
* file sharing password widget
*/
function passwidget()
{
    if ($('#use_pass').prop('checked')) {
        $('.seclink').show();
    } else {
        $('.seclink').hide();
    } 
    $('.sharelink, .passlink').val('');
    $('.shalink, #sendfiles, .openmail').hide();
    $('.passlink').prop('readonly', false);
    $('.createlink-wrap').fadeIn();
}

$(document).on('change', '#use_pass', function() {
    $('.alert').alert('close');
    passwidget();
});

/**
* change input value on select files
*/
$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});

/**
* Check - Uncheck all
*/
$(document).on('click', '#selectall', function (e) {
    e.preventDefault();
    $('.selecta').prop('checked', !$('.selecta').prop('checked'));
    checkSelecta();
});

/**
* Check - Uncheck single items in grid view
*/
$(document).on('click', '.gridview .name', function(e) {
    var $rowa = $(this).parent('.rowa');
    var $selecta = $rowa.find('.selecta');
    $selecta.prop('checked', !$selecta.prop('checked'));
    checkSelecta();
});

/**
* Disable/Enable group action buttons & new directory submit
*/

function checkSelecta(){
    $('.selecta').each(function(){
        var $rowa = $(this).closest('.rowa');
        if ($(this).prop('checked')) {
            $rowa.addClass('attivo');
        } else {
            $rowa.removeClass('attivo');
        }
    });

    if ($('.selecta:checked').length > 0) {
        $('.groupact, .manda').attr("disabled", false);
        $('#creatorderlist').attr("disabled", false);
    } else {
        $('.groupact, .manda').attr("disabled", true);
        $('#creatorderlist').attr("disabled", true);
    } 
}

function orderSelecta(){
    var orderlist=[];
    var k = 0;
    $('.selecta').each(function(){
        
        if ($(this).prop('checked')) {
            var $ext = $(this).next().data('thisext');
            var $thisfile = $(this).next().data('thisfile');
            var $username = $('#username').val(); 
            if ($ext == 'pdf' ||$ext == 'docx' ||$ext == 'doc'
                ||$ext == 'ppt'||$ext == 'pptx'||$ext == 'xls'
                ||$ext == 'xlsx'  ) {     
                  
                    orderlist[k] = {
                        'thisfile':$thisfile,
                        'username':$username,
                        'ext':$ext
                    };
                    k++;
                }
            }  
        });
         return orderlist;       
    }


$(document).ready(function(){

    $('.groupact, .manda, .upfolder').attr("disabled", true);
    checkSelecta();

    $('.upload_dirname').keyup(function() {
        if($(this).val().length > 0){
            $('.upfolder').attr("disabled", false);
        } else {
            $('.upfolder').attr("disabled", true);
       }
    });
});

/**
* Get highest value from array.
*/
function getHighest($array) {
    var biggest = Math.max.apply( null, $array );
    return biggest;
}

/**
* Set placeholder height.
*/
function placeHolderheight(){
    var arrayW = [];
    var thisW;
    $('.icon-placeholder').css('height', '30px');
    $('.inlinethumbs .icon-placeholder').css('height', '60px');
    $('.gridview .icon-placeholder').each(function(){
        thisW = $(this).width();
        arrayW.push(thisW);
    });
    var biggest = getHighest(arrayW);
    $('.gridview .icon-placeholder').css('height', biggest);
}

/**
* Update session data.
*/
function updateSession($data){
    $.ajax({
    method: "POST",
    url: "vfm-admin/ajax/session.php",
        data: $data
    });
}

/**
* Switch grid view and list view.
*/
$(document).on('click', '.switchview', function(e) {
    $switcher = $(this);
    e.preventDefault();
    $('#sort').animate({
        opacity: 0
    }, 300, 'linear', function() {
        $('#sort').toggleClass('gridview');
        // redraw placeholder height
        placeHolderheight();

        if ($switcher.hasClass('grid')) {
            $switcher.removeClass('grid');
            updateSession({ lilstview: 'list' });
            // redraw table current page column size
            oTable.columns.adjust().draw('page');
        
        } else {
            $switcher.addClass('grid');
            updateSession({ lilstview: 'grid' });
        }
        $('#sort').animate({
            opacity: 1
        }, 300, 'linear');
    });
});

/**
* Adjust grid view item height
*/
$(window).on('load', function(){
    placeHolderheight();
});

$(window).resize(function(){
    placeHolderheight();
});

$(document).on('change', '.selecta', function () {
    checkSelecta();
});

/**
* Activate tooltips
*/
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip({
    // container: 'body'
  });
});

/**
* Check - Uncheck all users
*/
$(document).on('click', '.selectallusers', function() {
    $('.selectme').prop('checked',!$('.selectme').prop('checked'));
    checkNotiflist();
});

/**
* Change notify users icon
*/
function checkNotiflist(){
    var anyUserChecked = $('#userslist :checkbox:checked').length > 0;
    if (anyUserChecked == true) {
        $('.check-notif').removeClass('fa-circle-o').addClass('fa-check-circle');
    } else {
        $('.check-notif').removeClass('fa-check-circle').addClass('fa-circle-o');
    }
}

$(document).ready(function(){
    $('#userslist :checkbox').change(function() {
        checkNotiflist();
    });
});

/**
* Fade In filemanager tables on load
*/
var loaded = false;

$(window).on('load', function(){
    if(!loaded) {
        $('.ghost').removeClass('ghost-hidden');
        loaded = true;
    }
});

/**
* if the page takes more than 3 seconds to load fade in the table
*/
$(document).ready(function(){
    var loadtime = 3000;
    setTimeout(function() { 
        if(!loaded) {
            $('.ghost').removeClass('ghost-hidden');
            loaded = true;
        }  
    }, loadtime);
});

var paginationTemplate = {
    emptyTable     : '--',
    info           : '_START_-_END_ / _TOTAL_ ',
    infoEmpty      : '',
    infoFiltered   : '',
    infoPostFix    : '',
    lengthMenu     : '_MENU_',
    loadingRecords : '<i class="fa fa-refresh fa-spin"></i>',
    processing     : '<i class="fa fa-refresh fa-spin"></i>',
    search         : '<span class="input-group-addon"><i class="fa fa-search"></i></span> ',
    zeroRecords    : '--',
    paginate : {
        first    : '<i class="fa fa-angle-double-left"></i>',
        last     : '<i class="fa fa-angle-double-right"></i>',
        previous : '<i class="fa fa-angle-left"></i>',
        next     : '<i class="fa fa-angle-right"></i>'
    }
}

/** 
 * Change pagination element position via DOM:
 * https://datatables.net/examples/basic_init/dom.html
 * http://veno.es/support/24-change-position-to-table-pagination-elements
 */

/**
* SetUp datatable for Folders
*/
function callFoldersTable($sPaginationType, $iDisplayLength, $fnSortcol, $fnSortdir, $dirpaginate){

    var fTable, folderdom, paging, searching;

    if ($dirpaginate == 'off') {
        folderdom = 'rt';
        $iDisplayLength = -1;
    } else {
        folderdom = '<"table-controls-top"fl>rt<"table-controls-bottom"ip>';
    }

    $.extend($.fn.dataTableExt.oStdClasses, {
        sSortAsc  : 'header headerSortDown',
        sSortDesc : 'header headerSortUp',
        sSortable : 'header'
    }); 

    fTable = $('#sortable').DataTable({
        dom : folderdom,
        pagingType : $sPaginationType,
        order : [ [$fnSortcol, $fnSortdir] ],
        columnDefs : [ 
            { 
                width      : '5%',
                targets    : [ 0 ],
            },
            { 
                width      : '60%',
                targets    : [ 1 ],
                orderable  : true,
                searchable : true,
                type       : 'natural'
            },
            { 
                width     : '20%',
                targets   : [ 2 ],
                orderable : true
            },
            { 
                targets    : ['_all'], 
                orderable  : false, 
                searchable : false
            }
        ],
        lengthMenu : [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
        pageLength : $iDisplayLength,
        language : paginationTemplate,
        drawCallback : function() { 
            // hide pagination if we have only one page
            var api = this.api();
            var pageinfo = api.page.info();
            var paginateRow = $(this).parent().find('.dataTables_paginate');  

            if (pageinfo.recordsDisplay <= api.page.len()) {
                paginateRow.css('display', 'none');
            } else {
                paginateRow.css('display', 'block');
            }
        }
    });
}

/**
 * SetUp datatable for Files
 */
var oTable;

function callFilesTable($sPaginationType, $bPaginate, $bFilter, $iDisplayLength, $fnSortcol, $fnSortdir){

    $.extend($.fn.dataTableExt.oStdClasses, {
        sSortAsc  : 'header headerSortDown',
        sSortDesc : 'header headerSortUp',
        sSortable : 'header'
    }); 

    oTable = $('#sort').DataTable({
        dom : '<"table-controls-top"fl>rt<"table-controls-bottom"ip>',
        pagingType : $sPaginationType,
        paging : $bPaginate,
        searching : $bFilter,
        pageLength : $iDisplayLength,
        order : [ [$fnSortcol, $fnSortdir] ],
        columnDefs : [
            { 
                width      : '50%',
                targets    : [ 2 ],
                orderable  : true,
                searchable : true,
                type       : 'natural'
            },
            { 
                width      : '10%',
                targets   : [ 3 ],
                orderable : true
            },
            { 
                width      : '20%',
                targets   : [ 4 ],
                orderable : true
            },
            { 
                targets    : ['_all'], 
                orderable  : false,
                searchable : false
            }
        ],
        language : paginationTemplate,
        drawCallback : function() {

            checkSelecta();
            placeHolderheight();

            // hide pagination if we have only one page
            var api = this.api();
            var pageinfo = api.page.info();
            var paginateRow = $(this).parent().find('.dataTables_paginate');  

            if (pageinfo.recordsDisplay <= api.page.len()) {
                paginateRow.css('display', 'none');
            } else {
                paginateRow.css('display', 'block');
            }
        }
    });

    oTable.on( 'length.dt', function ( e, settings, len ) {
        updateSession({ iDisplayLength: len });
    });
}

$(document).on('click', '.downzip', function() {
    $('#zipmodal').modal('hide');
});


function createZip(folder, dash){

    // var loader = '<span class="pulse">Please wait...</span>';
    var arrows = '<i class="fa fa-angle-double-right fa-3x fa-fw passing-animated"></i>';
    var checked = '<i class="fa fa-check fa-3x fa-fw"></i>'
    var erroricon = '<i class="fa fa-times fa-3x fa-fw"></i>'

    // $('#zipmodal .zipresp').html(loader);
    $('#zipmodal .ziparrow').html(arrows);

    $('#zipmodal').modal();

    $.ajax({
        cache: false,
        type: "POST",
        url: "vfm-admin/ajax/zip.php?t=" + (new Date).getTime(),
        data: {
            fold: folder,
            dash: dash
        }
    })
    .done(function( msg ) {
        
        var json = $.parseJSON(msg); 

        if (json.error === false) {
            var message = '<a class="btn btn-primary btn-block downzip" href="'
            + json.link +'"><i class="fa fa-download"></i> '
            + json.filename +'</a>';
            $('#zipmodal .ziparrow').html(checked);
            // console.log(json);
        } else {
            var message = json.error;
            $('#zipmodal .ziparrow').html(erroricon);
        }
        $('#zipmodal .zipresp').html(message);

        if ($('.downzip').length && ! $("#zipmodal").data('bs.modal').isShown) {
            var zipdest = $('.downzip').attr('href');
            $('.downzip').remove();
            window.location.href = zipdest;
        }
    })
    .fail(function() {
        alert('ERROR generating zip');
    });
}


function callBindZip($message){

    var bindZip = function(event) {

        var folder = $(this).data('zip');
        var foldername = $(this).data('thisname');

        var dash = $(this).data('dash');
        var $fullmessage = '<i class="fa fa-cloud-download fa-2x"></i><br>' + $message + ': <strong>' + foldername + '</strong>';

        event.preventDefault();
        $(document).off('click', '.zipdir');

        bootbox.confirm({
            size: 'small',
            message: $fullmessage, 
            callback: function(result) {
                $(document).on('click', '.zipdir', bindZip);
                if (result) {
                    createZip(folder, dash);
                }
            }
        });
    };
    $(document).on('click', '.zipdir', bindZip);
}

/**
* FILE SHARING
*/
function createShareLink($insert4, $time, $hash, $pulito, $activepagination, $maxzipfiles, $selectfiles, $toomanyfiles, $prettylinks) {

    var dvar;

    $(document).on('click', '#createlink', function() {

        $('.alert').alert('close');
        var alertmess = '<div class="alert alert-warning alert-dismissible" role="alert">' + $insert4 + '</div>';
        var shortlink, passw
        // check if wants a password
        if ($('#use_pass').prop('checked')) {
            if (!$('.setpass').val()) {
                passw = randomstring();
            } else {
                if ($('.setpass').val().length < 4) {
                    $('.setpass').focus();
                    $('.seclink').after(alertmess);
                    return;
                } else {
                    passw = $('.setpass').val();
                }
            }  
        }

        $.ajax({
            cache: false,
            type: "POST",
            url: "vfm-admin/ajax/shorten.php",
            data: {
                atts: divar.join(','),
                time: $time,
                hash: $hash,
                pass: passw
            }
        })
        .done(function( msg ) {
            shortlink = $pulito + '/?dl=' + msg;
            $('.sharelink').val(shortlink);
            $('.sharebutt').attr('href', shortlink);
            $('.passlink').val(passw);
            $('.passlink').prop('readonly', true);
            
            $('.createlink-wrap').fadeOut('fast', function(){
                $('.shalink').fadeIn();
                $('.openmail').fadeIn();
            });
        })
        .fail(function() {
            console.log('ERROR generating shortlink');
        });
    });
    
    $(document).on('keyup keypress', '#sendfiles', function(e){
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });

    $(document).on('click', '.manda', function () {

        var numfiles, selectors;
        divar = [];

        if ($activepagination == true) {
            selectors = $('.selecta:checked', oTable.rows().nodes());
        } else {
            selectors = $('.selecta:checked');
        }
        
        numfiles = selectors.size();

        if (numfiles > 0) {            
            selectors.each(function(){
                divar.push($(this).val());
            });
            // reset form
            $('.addest').val('');
            $('.bcc-address').remove();

            $('.seclink, .shalink, .mailresponse, #sendfiles, .openmail').hide();
            $('.sharelink, .passlink').val('');
            $('.sharebutt').attr('href', '#');
            $('.createlink-wrap').fadeIn();

            passwidget();

            // populate send inputs
            $('.attach').val(divar.join(','));
            $('.numfiles').html(numfiles);

            // open modal
            $('#sendfilesmodal').modal();

            $('#sendfiles').unbind('submit').submit(function(event) {
                event.preventDefault();
                $('.mailpreload').fadeIn();
                var now = $.now();

                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "vfm-admin/ajax/sendfiles.php?t=" + now,
                    data: $('#sendfiles').serialize()
                })
                .done(function( msg ) {
                    $('.mailresponse').html('<div class="alert alert-success">' + msg + '</div>').fadeIn();
                    $('.addest').val('');
                    $('.bcc-address').remove();
                    $('.mailpreload').fadeOut();
                })
                .fail(function() {
                    $('.mailpreload').fadeOut();
                    $('.mailresponse').html('<div class="alert alert-danger">Error</div>');
                });
            });
        } else {
            alert($selectfiles);
        }
    }); // end .manda click

    $(document).on('click', '.multid', function(e) {
        e.preventDefault();

        var numfiles, selectors;
        divar = [];

        if ($activepagination == true) {
            selectors = $('.selecta:checked', oTable.rows().nodes());
        } else {
            selectors = $('.selecta:checked');
        }
        numfiles = selectors.size();

        if (numfiles > 0) {

            selectors.each(function(){
                divar.push($(this).val());
            });

            if (numfiles >= $maxzipfiles) {
                alert($toomanyfiles + ' ' + $maxzipfiles);
            } else {
                // generate short url for multiple downloads
                var shortlink

                $.ajax({
                    cache: false,
                    type: "POST",
                    url: "vfm-admin/ajax/shorten.php",
                    data: {
                        atts: divar.join(','),
                        time: $time,
                        hash: $hash
                    }
                })
                .done(function( msg ) {
                    if ($prettylinks) {
                        shortlink = 'download/dl/' + msg;
                    } else {
                        shortlink = 'vfm-admin/vfm-downloader.php?dl=' + msg;
                    }
                    $('.sendlink').attr('href', shortlink);
                    $('#downloadmulti .numfiles').html(numfiles);
                    $('#downloadmulti').modal();
                })
                .fail(function() {
                    console.log('ERROR generating shortlink');
                });
            }
        } else {
            alert($selectfiles);
        }
    }); // end .multid click
}

/**
* DELETE FILES
*/
function setupDelete($confirmthisdel, $confirmdel, $activepagination, $time, $hash, $doit, $selectfiles) {
    //
    // Delete single files
    //
    
    var delSingle = function(event) {
        event.preventDefault();
        $(document).off('click', '.del a');

        var dest = $(this).attr('href');
        var message = '<br><strong>' + $(this).attr('data-name') + "<strong>";

        bootbox.confirm($confirmthisdel + message, function(result) {

            $(document).on('click', '.del a', delSingle );

            if (result) {

                // 删除数据库
                
                window.location.href = dest;
            }

        });
    };
    $(document).on('click', '.del a', delSingle );

    //
    // Delete multiple files
    //
    var delMulti = function(event) {
        event.preventDefault();
        $(document).off('click', '.removelink');

        bootbox.confirm($confirmdel, function(answer) {
        
            $(document).on('click', '.removelink', delMulti );

            var deldata = $('#delform').serializeArray();
            if (answer) {
                $.ajax({
                    type: "POST",
                    url: "vfm-admin/vfm-del.php",
                    data: deldata
                })
                .done(function( msg ) {
                    if (msg == 'ok') {
                        window.location = window.location.href.split('&del')[0];
                    } else {
                        $('.delresp').html(msg);
                    }
                })
                .fail(function() {
                    alert( 'error' );
                });
            }
        });
    }
    $(document).on('click', '.removelink', delMulti );

    //
    // Setup multi delete button
    //
    $(document).on('click', '.multic', function(e) {
        e.preventDefault();
        
        var numfiles, selectors;
        var divar = [];

        if ($activepagination == true) {
            selectors = $('.selecta:checked', oTable.rows().nodes());
        } else {
            selectors = $('.selecta:checked');
        }
        numfiles = selectors.size();

        if (numfiles > 0) { 
            selectors.each(function(){
                divar.push($(this).val());
            });
            $('#delform').append('<input type="hidden" name="setdel" value="' + divar + '">');
            $('#delform').append('<input type="hidden" name="t" value="' + $time + '">');
            $('#delform').append('<input type="hidden" name="h" value="' + $hash + '">');
            $('#delform').append('<input type="hidden" name="doit" value="' + $doit + '">');
            $('#deletemulti .numfiles').html(numfiles);
            $('#deletemulti').modal();
        } else {
            alert($selectfiles);
        }
    }); 
}

/**
* MOVE FILES
*/

function pupulateMoveCopyform($activepagination, $selectfiles, $time, $hash, $doit) {
    var numfiles, selectors;
    var divar = [];

    if ($activepagination == true) {
        selectors = $('.selecta:checked', oTable.rows().nodes());
    } else {
        selectors = $('.selecta:checked');
    }
    numfiles = selectors.size();
    if (numfiles > 0) { 
        selectors.each(function(){
            divar.push($(this).val());
        });
        $('#moveform').append('<input type="hidden" name="setmove" value="' + divar + '">');
        $('#moveform').append('<input type="hidden" name="t" value="' + $time + '">');
        $('#moveform').append('<input type="hidden" name="h" value="' + $hash + '">');
        $('#moveform').append('<input type="hidden" name="doit" value="' + $doit + '">');
        $('#movemulti').modal();
    } else {
        alert($selectfiles);
    }
}

function setupMove($activepagination, $selectfiles, $time, $hash, $doit) {

    // Setup multi move
    $(document).on('click', '.multimove', function(e) {
        e.preventDefault();
        $('#moveform').html('');
        $('#movemulti .hiddenalert').html('');

        pupulateMoveCopyform($activepagination, $selectfiles, $time, $hash, $doit)
    });

    // Setup multi copy form
    $(document).on('click', '.multicopy', function(e) {
        e.preventDefault();
        $('#moveform').html('');
        $('#movemulti .hiddenalert').html('');
        $('#moveform').append('<input type="hidden" name="copy" value="1">');

        pupulateMoveCopyform($activepagination, $selectfiles, $time, $hash, $doit)
    });

    $(document).on('click', '.movelink', function(e) {
        e.preventDefault();
        var dest = $(this).data('dest');
        $('#moveform').append('<input type="hidden" name="dest" value="' + dest + '">');

        var movedata = $('#moveform').serializeArray();

        $.ajax({
            cache: false,
            type: "POST",
            url: "vfm-admin/vfm-move.php?t=" + (new Date).getTime(),
            data: movedata
        })
        .done(function(msg) {
            if (msg == 'ok') {
                window.location = window.location.href.split('&del')[0];
            } else {
                var alert = '<div class="alert alert-danger" role="alert">'+msg+'</div>'
                $('#movemulti .hiddenalert').html(alert);
            }
        })
        .fail(function() {
            var alert = '<div class="alert alert-danger" role="alert">Error connecting vfm-move.php</div>'
            $('#movemulti .hiddenalert').html(alert);
        });
    });
}
