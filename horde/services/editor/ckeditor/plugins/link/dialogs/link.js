CKEDITOR.dialog.add("link",function(ad){var ac=CKEDITOR.plugins.link,ab=function(){var d=this.getDialog(),c=d.getContentElement("target","popupFeatures"),b=d.getContentElement("target","linkTargetName"),a=this.getValue();if(!c||!b){return}c=c.getElement();c.hide();b.setValue("");switch(a){case"frame":b.setLabel(ad.lang.link.targetFrameName);b.getElement().show();break;case"popup":c.show();b.setLabel(ad.lang.link.targetPopupName);b.getElement().show();break;default:b.setValue(a);b.getElement().hide();break}},aa=function(){var g=this.getDialog(),f=["urlOptions","anchorOptions","emailOptions"],e=this.getValue(),d=g.definition.getContents("upload"),c=d&&d.hidden;if(e=="url"){if(ad.config.linkShowTargetTab){g.showPage("target")}if(!c){g.showPage("upload")}}else{g.hidePage("target");if(!c){g.hidePage("upload")}}for(var b=0;b<f.length;b++){var a=g.getContentElement("info",f[b]);if(!a){continue}a=a.getElement().getParent().getParent();if(f[b]==e+"Options"){a.show()}else{a.hide()}}},Z=/^javascript:/,Y=/^mailto:([^?]+)(?:\?(.+))?$/,X=/subject=([^;?:@&=$,\/]*)/,W=/body=([^;?:@&=$,\/]*)/,V=/^#(.*)$/,U=/^((?:http|https|ftp|news):\/\/)?(.*)$/,T=/^(_(?:self|top|parent|blank))$/,S=/^javascript:void\(location\.href='mailto:'\+String\.fromCharCode\(([^)]+)\)(?:\+'(.*)')?\)$/,R=/^javascript:([^(]+)\(([^)]+)\)$/,Q=/\s*window.open\(\s*this\.href\s*,\s*(?:'([^']*)'|null)\s*,\s*'([^']*)'\s*\)\s*;\s*return\s*false;*\s*/,P=/(?:^|,)([^=]+)=(\d+|yes|no)/gi,O=function(w,v){var u=v&&(v.getAttribute("_cke_saved_href")||v.getAttribute("href"))||"",t,s,r,q,p={};if(t=u.match(Z)){if(D=="encode"){u=u.replace(S,function(z,y,x){return"mailto:"+String.fromCharCode.apply(String,y.split(","))+(x&&F(x))})}else{if(D){u.replace(R,function(y,x,am){if(x==C.name){p.type="email";var al=p.email={},ak=/[^,\s]+/g,aj=/(^')|('$)/g,ai=am.match(ak),ah=ai.length,B,A;for(var z=0;z<ah;z++){A=decodeURIComponent(F(ai[z].replace(aj,"")));B=C.params[z].toLowerCase();al[B]=A}al.address=[al.name,al.domain].join("@")}})}}}if(!p.type){if(r=u.match(V)){p.type="anchor";p.anchor={};p.anchor.name=p.anchor.id=r[1]}else{if(s=u.match(Y)){var o=u.match(X),n=u.match(W);p.type="email";var m=p.email={};m.address=s[1];o&&(m.subject=decodeURIComponent(o[1]));n&&(m.body=decodeURIComponent(n[1]))}else{if(u&&(q=u.match(U))){p.type="url";p.url={};p.url.protocol=q[1];p.url.url=q[2]}else{p.type="url"}}}}if(v){var l=v.getAttribute("target");p.target={};p.adv={};if(!l){var k=v.getAttribute("_cke_pa_onclick")||v.getAttribute("onclick"),j=k&&k.match(Q);if(j){p.target.type="popup";p.target.name=j[1];var i;while(i=P.exec(j[2])){if(i[2]=="yes"||i[2]=="1"){p.target[i[1]]=true}else{if(isFinite(i[2])){p.target[i[1]]=i[2]}}}}}else{var h=l.match(T);if(h){p.target.type=p.target.name=l}else{p.target.type="frame";p.target.name=l}}var g=this,f=function(z,y){var x=v.getAttribute(y);if(x!==null){p.adv[z]=x||""}};f("advId","id");f("advLangDir","dir");f("advAccessKey","accessKey");f("advName","name");f("advLangCode","lang");f("advTabIndex","tabindex");f("advTitle","title");f("advContentType","type");f("advCSSClasses","class");f("advCharset","charset");f("advStyles","style")}var e=w.document.getElementsByTag("img"),d=new CKEDITOR.dom.nodeList(w.document.$.anchors),c=p.anchors=[];for(var b=0;b<e.count();b++){var a=e.getItem(b);if(a.getAttribute("_cke_realelement")&&a.getAttribute("_cke_real_element_type")=="anchor"){c.push(w.restoreRealElement(a))}}for(b=0;b<d.count();b++){c.push(d.getItem(b))}for(b=0;b<c.length;b++){a=c[b];c[b]={name:a.getAttribute("name"),id:a.getAttribute("id")}}this._.selectedElement=v;return p},M=function(b,a){if(a[b]){this.setValue(a[b][this.id]||"")}},K=function(a){return M.call(this,"target",a)},J=function(a){return M.call(this,"adv",a)},I=function(b,a){if(!a[b]){a[b]={}}a[b][this.id]=this.getValue()||""},H=function(a){return I.call(this,"target",a)},G=function(a){return I.call(this,"adv",a)};function F(a){return a.replace(/\\'/g,"'")}function E(a){return a.replace(/'/g,"\\$&")}var D=ad.config.emailProtection||"";if(D&&D!="encode"){var C={};D.replace(/^([^(]+)\(([^)]+)\)$/,function(c,b,a){C.name=b;C.params=[];a.replace(/[^,\s]+/g,function(d){C.params.push(d)})})}function N(g){var f,e=C.name,d=C.params,c,b;f=[e,"("];for(var a=0;a<d.length;a++){c=d[a].toLowerCase();b=g[c];a>0&&f.push(",");f.push("'",b?E(encodeURIComponent(g[c])):"","'")}f.push(")");return f.join("")}function L(e){var d,c=e.length,b=[];for(var a=0;a<c;a++){d=e.charCodeAt(a);b.push(d)}return"String.fromCharCode("+b.join(",")+")"}return{title:ad.lang.link.title,minWidth:350,minHeight:230,contents:[{id:"info",label:ad.lang.link.info,title:ad.lang.link.info,elements:[{id:"linkType",type:"select",label:ad.lang.link.type,"default":"url",items:[[ad.lang.link.toUrl,"url"],[ad.lang.link.toAnchor,"anchor"],[ad.lang.link.toEmail,"email"]],onChange:aa,setup:function(a){if(a.type){this.setValue(a.type)}},commit:function(a){a.type=this.getValue()}},{type:"vbox",id:"urlOptions",children:[{type:"hbox",widths:["25%","75%"],children:[{id:"protocol",type:"select",label:ad.lang.common.protocol,"default":"http://",items:[["http://???","http://"],["https://???","https://"],["ftp://???","ftp://"],["news://???","news://"],[ad.lang.link.other,""]],setup:function(a){if(a.url){this.setValue(a.url.protocol||"")}},commit:function(a){if(!a.url){a.url={}}a.url.protocol=this.getValue()}},{type:"text",id:"url",label:ad.lang.common.url,required:true,onLoad:function(){this.allowOnChange=true},onKeyUp:function(){var a=this;a.allowOnChange=false;var f=a.getDialog().getContentElement("info","protocol"),e=a.getValue(),d=/^(http|https|ftp|news):\/\/(?=.)/gi,c=/^((javascript:)|[#\/\.\?])/gi,b=d.exec(e);if(b){a.setValue(e.substr(b[0].length));f.setValue(b[0].toLowerCase())}else{if(c.test(e)){f.setValue("")}}a.allowOnChange=true},onChange:function(){if(this.allowOnChange){this.onKeyUp()}},validate:function(){var b=this.getDialog();if(b.getContentElement("info","linkType")&&b.getValueOf("info","linkType")!="url"){return true}if(this.getDialog().fakeObj){return true}var a=CKEDITOR.dialog.validate.notEmpty(ad.lang.link.noUrl);return a.apply(this)},setup:function(a){this.allowOnChange=false;if(a.url){this.setValue(a.url.url)}this.allowOnChange=true},commit:function(a){this.onChange();if(!a.url){a.url={}}a.url.url=this.getValue();this.allowOnChange=false}}],setup:function(a){if(!this.getDialog().getContentElement("info","linkType")){this.getElement().show()}}},{type:"button",id:"browse",hidden:"true",filebrowser:"info:url",label:ad.lang.common.browseServer}]},{type:"vbox",id:"anchorOptions",width:260,align:"center",padding:0,children:[{type:"fieldset",id:"selectAnchorText",label:ad.lang.link.selectAnchor,setup:function(a){if(a.anchors.length>0){this.getElement().show()}else{this.getElement().hide()}},children:[{type:"hbox",id:"selectAnchor",children:[{type:"select",id:"anchorName","default":"",label:ad.lang.link.anchorName,style:"width: 100%;",items:[[""]],setup:function(d){var a=this;a.clear();a.add("");for(var c=0;c<d.anchors.length;c++){if(d.anchors[c].name){a.add(d.anchors[c].name)}}if(d.anchor){a.setValue(d.anchor.name)}var b=a.getDialog().getContentElement("info","linkType");if(b&&b.getValue()=="email"){a.focus()}},commit:function(a){if(!a.anchor){a.anchor={}}a.anchor.name=this.getValue()}},{type:"select",id:"anchorId","default":"",label:ad.lang.link.anchorId,style:"width: 100%;",items:[[""]],setup:function(c){var a=this;a.clear();a.add("");for(var b=0;b<c.anchors.length;b++){if(c.anchors[b].id){a.add(c.anchors[b].id)}}if(c.anchor){a.setValue(c.anchor.id)}},commit:function(a){if(!a.anchor){a.anchor={}}a.anchor.id=this.getValue()}}],setup:function(a){if(a.anchors.length>0){this.getElement().show()}else{this.getElement().hide()}}}]},{type:"html",id:"noAnchors",style:"text-align: center;",html:'<div role="label" tabIndex="-1">'+CKEDITOR.tools.htmlEncode(ad.lang.link.noAnchors)+"</div>",focus:true,setup:function(a){if(a.anchors.length<1){this.getElement().show()}else{this.getElement().hide()}}}],setup:function(a){if(!this.getDialog().getContentElement("info","linkType")){this.getElement().hide()}}},{type:"vbox",id:"emailOptions",padding:1,children:[{type:"text",id:"emailAddress",label:ad.lang.link.emailAddress,required:true,validate:function(){var b=this.getDialog();if(!b.getContentElement("info","linkType")||b.getValueOf("info","linkType")!="email"){return true}var a=CKEDITOR.dialog.validate.notEmpty(ad.lang.link.noEmail);return a.apply(this)},setup:function(b){if(b.email){this.setValue(b.email.address)}var a=this.getDialog().getContentElement("info","linkType");if(a&&a.getValue()=="email"){this.select()}},commit:function(a){if(!a.email){a.email={}}a.email.address=this.getValue()}},{type:"text",id:"emailSubject",label:ad.lang.link.emailSubject,setup:function(a){if(a.email){this.setValue(a.email.subject)}},commit:function(a){if(!a.email){a.email={}}a.email.subject=this.getValue()}},{type:"textarea",id:"emailBody",label:ad.lang.link.emailBody,rows:3,"default":"",setup:function(a){if(a.email){this.setValue(a.email.body)}},commit:function(a){if(!a.email){a.email={}}a.email.body=this.getValue()}}],setup:function(a){if(!this.getDialog().getContentElement("info","linkType")){this.getElement().hide()}}}]},{id:"target",label:ad.lang.link.target,title:ad.lang.link.target,elements:[{type:"hbox",widths:["50%","50%"],children:[{type:"select",id:"linkTargetType",label:ad.lang.common.target,"default":"notSet",style:"width : 100%;",items:[[ad.lang.common.notSet,"notSet"],[ad.lang.link.targetFrame,"frame"],[ad.lang.link.targetPopup,"popup"],[ad.lang.common.targetNew,"_blank"],[ad.lang.common.targetTop,"_top"],[ad.lang.common.targetSelf,"_self"],[ad.lang.common.targetParent,"_parent"]],onChange:ab,setup:function(a){if(a.target){this.setValue(a.target.type)}},commit:function(a){if(!a.target){a.target={}}a.target.type=this.getValue()}},{type:"text",id:"linkTargetName",label:ad.lang.link.targetFrameName,"default":"",setup:function(a){if(a.target){this.setValue(a.target.name)}},commit:function(a){if(!a.target){a.target={}}a.target.name=this.getValue().replace(/\W/gi,"")}}]},{type:"vbox",width:260,align:"center",padding:2,id:"popupFeatures",children:[{type:"fieldset",label:ad.lang.link.popupFeatures,children:[{type:"hbox",children:[{type:"checkbox",id:"resizable",label:ad.lang.link.popupResizable,setup:K,commit:H},{type:"checkbox",id:"status",label:ad.lang.link.popupStatusBar,setup:K,commit:H}]},{type:"hbox",children:[{type:"checkbox",id:"location",label:ad.lang.link.popupLocationBar,setup:K,commit:H},{type:"checkbox",id:"toolbar",label:ad.lang.link.popupToolbar,setup:K,commit:H}]},{type:"hbox",children:[{type:"checkbox",id:"menubar",label:ad.lang.link.popupMenuBar,setup:K,commit:H},{type:"checkbox",id:"fullscreen",label:ad.lang.link.popupFullScreen,setup:K,commit:H}]},{type:"hbox",children:[{type:"checkbox",id:"scrollbars",label:ad.lang.link.popupScrollBars,setup:K,commit:H},{type:"checkbox",id:"dependent",label:ad.lang.link.popupDependent,setup:K,commit:H}]},{type:"hbox",children:[{type:"text",widths:["30%","70%"],labelLayout:"horizontal",label:ad.lang.link.popupWidth,id:"width",setup:K,commit:H},{type:"text",labelLayout:"horizontal",widths:["55%","45%"],label:ad.lang.link.popupLeft,id:"left",setup:K,commit:H}]},{type:"hbox",children:[{type:"text",labelLayout:"horizontal",widths:["30%","70%"],label:ad.lang.link.popupHeight,id:"height",setup:K,commit:H},{type:"text",labelLayout:"horizontal",label:ad.lang.link.popupTop,widths:["55%","45%"],id:"top",setup:K,commit:H}]}]}]}]},{id:"upload",label:ad.lang.link.upload,title:ad.lang.link.upload,hidden:true,filebrowser:"uploadButton",elements:[{type:"file",id:"upload",label:ad.lang.common.upload,style:"height:40px",size:29},{type:"fileButton",id:"uploadButton",label:ad.lang.common.uploadSubmit,filebrowser:"info:url","for":["upload","upload"]}]},{id:"advanced",label:ad.lang.link.advanced,title:ad.lang.link.advanced,elements:[{type:"vbox",padding:1,children:[{type:"hbox",widths:["45%","35%","20%"],children:[{type:"text",id:"advId",label:ad.lang.link.id,setup:J,commit:G},{type:"select",id:"advLangDir",label:ad.lang.link.langDir,"default":"",style:"width:110px",items:[[ad.lang.common.notSet,""],[ad.lang.link.langDirLTR,"ltr"],[ad.lang.link.langDirRTL,"rtl"]],setup:J,commit:G},{type:"text",id:"advAccessKey",width:"80px",label:ad.lang.link.acccessKey,maxLength:1,setup:J,commit:G}]},{type:"hbox",widths:["45%","35%","20%"],children:[{type:"text",label:ad.lang.link.name,id:"advName",setup:J,commit:G},{type:"text",label:ad.lang.link.langCode,id:"advLangCode",width:"110px","default":"",setup:J,commit:G},{type:"text",label:ad.lang.link.tabIndex,id:"advTabIndex",width:"80px",maxLength:5,setup:J,commit:G}]}]},{type:"vbox",padding:1,children:[{type:"hbox",widths:["45%","55%"],children:[{type:"text",label:ad.lang.link.advisoryTitle,"default":"",id:"advTitle",setup:J,commit:G},{type:"text",label:ad.lang.link.advisoryContentType,"default":"",id:"advContentType",setup:J,commit:G}]},{type:"hbox",widths:["45%","55%"],children:[{type:"text",label:ad.lang.link.cssClasses,"default":"",id:"advCSSClasses",setup:J,commit:G},{type:"text",label:ad.lang.link.charset,"default":"",id:"advCharset",setup:J,commit:G}]},{type:"hbox",children:[{type:"text",label:ad.lang.link.styles,"default":"",id:"advStyles",setup:J,commit:G}]}]}]}],onShow:function(){var a=this;a.fakeObj=false;var d=a.getParentEditor(),c=d.getSelection(),b=null;if((b=ac.getSelectedLink(d))&&b.hasAttribute("href")){c.selectElement(b)}else{if((b=c.getSelectedElement())&&b.is("img")&&b.getAttribute("_cke_real_element_type")&&b.getAttribute("_cke_real_element_type")=="anchor"){a.fakeObj=b;b=d.restoreRealElement(a.fakeObj);c.selectElement(a.fakeObj)}else{b=null}}a.setupContent(O.apply(a,[d,b]))},onOk:function(){var x={href:"javascript:void(0)/*"+CKEDITOR.tools.getNextNumber()+"*/"},w=[],v={href:x.href},u=this,t=this.getParentEditor();this.commitContent(v);switch(v.type||"url"){case"url":var s=v.url&&v.url.protocol!=undefined?v.url.protocol:"http://",r=v.url&&v.url.url||"";x._cke_saved_href=r.indexOf("/")===0?r:s+r;break;case"anchor":var q=v.anchor&&v.anchor.name,p=v.anchor&&v.anchor.id;x._cke_saved_href="#"+(q||p||"");break;case"email":var o,n=v.email,m=n.address;switch(D){case"":case"encode":var l=encodeURIComponent(n.subject||""),k=encodeURIComponent(n.body||""),j=[];l&&j.push("subject="+l);k&&j.push("body="+k);j=j.length?"?"+j.join("&"):"";if(D=="encode"){o=["javascript:void(location.href='mailto:'+",L(m)];j&&o.push("+'",E(j),"'");o.push(")")}else{o=["mailto:",m,j]}break;default:var i=m.split("@",2);n.name=i[0];n.domain=i[1];o=["javascript:",N(n)]}x._cke_saved_href=o.join("");break}if(v.target){if(v.target.type=="popup"){var h=["window.open(this.href, '",v.target.name||"","', '"],g=["resizable","status","location","toolbar","menubar","fullscreen","scrollbars","dependent"],f=g.length,e=function(ai){if(v.target[ai]){g.push(ai+"="+v.target[ai])}};for(var d=0;d<f;d++){g[d]=g[d]+(v.target[g[d]]?"=yes":"=no")}e("width");e("left");e("height");e("top");h.push(g.join(","),"'); return false;");x._cke_pa_onclick=h.join("")}else{if(v.target.type!="notSet"&&v.target.name){x.target=v.target.name}else{w.push("target")}w.push("_cke_pa_onclick","onclick")}}if(v.adv){var c=function(al,ak){var am=v.adv[al];if(am){x[ak]=am}else{w.push(ak)}};if(this._.selectedElement){c("advId","id")}c("advLangDir","dir");c("advAccessKey","accessKey");c("advName","name");c("advLangCode","lang");c("advTabIndex","tabindex");c("advTitle","title");c("advContentType","type");c("advCSSClasses","class");c("advCharset","charset");c("advStyles","style")}if(!this._.selectedElement){var b=t.getSelection(),a=b.getRanges();if(a.length==1&&a[0].collapsed){var ag=new CKEDITOR.dom.text(x._cke_saved_href,t.document);a[0].insertNode(ag);a[0].selectNodeContents(ag);b.selectRanges(a)}var af=new CKEDITOR.style({element:"a",attributes:x});af.type=CKEDITOR.STYLE_INLINE;af.apply(t.document);if(v.adv&&v.adv.advId){var ae=this.getParentEditor().document.$.getElementsByTagName("a");for(d=0;d<ae.length;d++){if(ae[d].href==x.href){ae[d].id=v.adv.advId;break}}}}else{var B=this._.selectedElement,A=B.getAttribute("_cke_saved_href"),z=B.getHtml();if(CKEDITOR.env.ie&&x.name!=B.getAttribute("name")){var y=new CKEDITOR.dom.element('<a name="'+CKEDITOR.tools.htmlEncode(x.name)+'">',t.document);b=t.getSelection();B.moveChildren(y);B.copyAttributes(y,{name:1});y.replace(B);B=y;b.selectElement(B)}B.setAttributes(x);B.removeAttributes(w);if(A==z){B.setHtml(x._cke_saved_href)}if(B.getAttribute("name")){B.addClass("cke_anchor")}else{B.removeClass("cke_anchor")}if(this.fakeObj){t.createFakeElement(B,"cke_anchor","anchor").replace(this.fakeObj)}delete this._.selectedElement}},onLoad:function(){if(!ad.config.linkShowAdvancedTab){this.hidePage("advanced")}if(!ad.config.linkShowTargetTab){this.hidePage("target")}},onFocus:function(){var b=this.getContentElement("info","linkType"),a;if(b&&b.getValue()=="url"){a=this.getContentElement("info","url");a.select()}}}});