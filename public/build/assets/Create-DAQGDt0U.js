const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/TheDiscount-DWUu6MvW.js","assets/app-LDVDDXIB.js","assets/app-ClSdrvIZ.css","assets/useHttpService-H3Bhthf8.js","assets/formatters-k0Na949k.js","assets/TheModal-aYJkSKq-.js","assets/TheCard-DltuzUPB.js","assets/TwoColumnRow-BlIMmxAF.js","assets/InputRange-Cp8YmIPk.js","assets/useArrayHandlers-JXOu8LuP.js","assets/SalesPeopleBoost-CFKiuiuC.js","assets/GiftForPurchase-BSRiC4qn.js","assets/Modal-Buqgi5Td.js","assets/RetailersBoost-BAT-AlBq.js"])))=>i.map(i=>d[i]);
import{o as i,c,f as t,t as y,g as n,w as d,j as u,T as q,u as ae,a as de,b as ie,a4 as V,r as H,e as ne,Z as B,B as C,d as F,p as m,s as v,I as S,F as h,h as P,i as s,q as D,m as p,L as ce,x as ue,l as I,a5 as k,a6 as j,H as _e,a7 as me,a8 as pe,n as he,a9 as G,aa as T,ab as A}from"./app-LDVDDXIB.js";import{u as ye}from"./useHttpService-H3Bhthf8.js";import{g as W}from"./formatters-k0Na949k.js";import{u as fe}from"./useArrayHandlers-JXOu8LuP.js";import{_ as K}from"./Modal-Buqgi5Td.js";var N={};Object.defineProperty(N,"__esModule",{value:!0});var L=N.default=void 0,ve={days:["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],daysShort:["Вос","Пон","Вто","Сре","Чет","Пят","Суб"],daysMin:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],months:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],monthsShort:["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"],today:"Сегодня",clear:"Очистить",dateFormat:"dd.MM.yyyy",timeFormat:"HH:mm",firstDay:1};L=N.default=ve;const be={class:"card"},ge={class:"card-header bg-dark text-white"},Se={class:"card-body mt-3"},Pe={class:"d-flex justify-content-between align-items-center"},Ie=t("span",null,"Инфо по покрытию",-1),Ee=t("hr",null,null,-1),Oe=t("div",{class:"row g-3"},null,-1),ke={__name:"CoverageIncrease",props:{title:{type:String,required:!0,default:"Title is required"}},setup(O){const b=O;return(_,f)=>(i(),c("div",null,[t("div",be,[t("div",ge,y(b.title),1),t("div",Se,[t("div",Pe,[Ie,t("button",{onClick:f[0]||(f[0]=(...g)=>_.addProductModalInit&&_.addProductModalInit(...g)),class:"btn btn-success",type:"button"}," Добавить ")]),Ee])]),n(K,{id:"modalPopUp","close-func":_.closeModal,"custom-classes":["modal-lg"]},{title:d(()=>[u(" Добавление ассортимента для промо-акции ")]),body:d(()=>[Oe]),footer:d(()=>[n(q,{onClick:_.addProduct,type:"button",class:"btn-success w-25",disabled:!_.isFormValid},{default:d(()=>[u(" Добавить ")]),_:1},8,["onClick","disabled"])]),_:1},8,["close-func"])]))}},Te={class:"card"},Ae={class:"card-header bg-danger text-white"},Re={class:"card-body mt-3"},we={class:"d-flex justify-content-between align-items-center"},xe=t("span",null,"Ассортимент для промо-акции",-1),Be=t("hr",null,null,-1),Ce=t("div",{class:"row g-3"},null,-1),Fe={__name:"TheInOut",props:{title:{type:String,required:!0,default:"Title is required"}},setup(O){const b=O;return(_,f)=>(i(),c("div",null,[t("div",Te,[t("div",Ae,y(b.title),1),t("div",Re,[t("div",we,[xe,t("button",{onClick:f[0]||(f[0]=(...g)=>_.addProductModalInit&&_.addProductModalInit(...g)),class:"btn btn-success",type:"button"}," Добавить ")]),Be])]),n(K,{id:"modalPopUp","close-func":_.closeModal,"custom-classes":["modal-lg"]},{title:d(()=>[u(" Добавление ассортимента для промо-акции ")]),body:d(()=>[Ce]),footer:d(()=>[n(q,{onClick:_.addProduct,type:"button",class:"btn-success w-25",disabled:!_.isFormValid},{default:d(()=>[u(" Добавить ")]),_:1},8,["onClick","disabled"])]),_:1},8,["close-func"])]))}},De={class:"row"},Le={class:"col-lg-5"},qe={class:"card"},Ne=t("div",{class:"card-header bg-primary text-white"},"Укажите общие данные промо-акции",-1),Ue={class:"card-body mt-3"},$e={class:"row g-3"},Me={class:"col-md-12"},Ve=t("option",{disabled:"",selected:"",value:""},"- Выберите вид промо-акции -",-1),He=["value"],je={class:"col-md-6"},Ge={class:"col-md-6"},We=["disabled"],Ke=t("option",{disabled:"",selected:"",value:""},"- Выберите канал продаж -",-1),ze=["value"],Ye={class:"col-md-6"},Ze=["disabled"],Je=t("option",{disabled:"",selected:"",value:""},"- Выберите дистрибутора -",-1),Qe=["value"],Xe={class:"col-md-6"},et=["disabled"],tt=t("option",{disabled:"",selected:"",value:""},"- Выберите торговую сеть -",-1),ot=["value"],st={class:"col-md-6"},rt=t("option",{disabled:"",selected:"",value:""},"- Выберите регион -",-1),lt=["value","selected"],at={class:"col-md-6"},dt=t("option",{disabled:"",selected:"",value:""},"- Выберите город -",-1),it=["value","selected"],nt={class:"col-md-6"},ct=t("div",{id:"start_date_help",class:"form-text"},"укажите дату начала акции",-1),ut={class:"col-md-6"},_t=t("div",{id:"end_date_help",class:"form-text"},"укажите дату окончания акции",-1),mt={class:"col-md-6"},pt={class:"input-group"},ht=["disabled"],yt={key:0,class:"input-group-text border-success bg-success text-white px-4"},ft={key:1,class:"input-group-text border-warning bg-warning px-4"},vt=t("div",{id:"products_help",class:"form-text"},"только для скидочных акций",-1),bt={class:"col-md-6"},gt={class:"input-group"},St=["disabled"],Pt={key:0,class:"input-group-text border-success bg-success text-white px-4"},It={key:1,class:"input-group-text border-warning bg-warning px-4"},Et=t("div",{id:"sellers_help",class:"form-text"},"только для мотивации ТП",-1),Ot={class:"col-12"},kt={class:"card-footer"},Tt={class:"col-lg-7"},At=t("p",null,"Loading...",-1),Rt=t("p",null,"Loading...",-1),wt=t("p",null,"Loading...",-1),xt=t("p",null,"Loading...",-1),Bt={key:6,class:"alert alert-warning alert-dismissible fade show",role:"alert"},Ct=t("h4",{class:"alert-heading"},"Детали промо-акции",-1),Ft=t("p",null,"Здесь будут выведены поля для ввода ассортимента, команды торговых представителей и др. в зависимости от выбранного вида промо-акции.",-1),Dt=t("hr",null,null,-1),Lt=t("p",null,"Выберите вид промо-акции в выпадающем списке в панели общих настроек промо-акции.",-1),qt=[Ct,Ft,Dt,Lt],Ht={__name:"Create",setup(O){const{get:b,post:_}=ye(),f=ae(),g=de(),z=_e(),U=ie().getUser,R=fe();V("#start_date",{locale:L,startDate:me,onSelect:({date:a,datepicker:r})=>{e.promo.startDate=W(a),r.hide()}}),V("#end_date",{locale:L,startDate:pe,onSelect:({date:a,datepicker:r})=>{e.promo.endDate=W(a),r.hide()}});const Y=T({loader:()=>A(()=>import("./TheDiscount-DWUu6MvW.js"),__vite__mapDeps([0,1,2,3,4,5,6,7,8,9]))}),Z=T({loader:()=>A(()=>import("./SalesPeopleBoost-CFKiuiuC.js"),__vite__mapDeps([10,1,2,3,9,4,8]))}),J=T(()=>A(()=>import("./GiftForPurchase-BSRiC4qn.js"),__vite__mapDeps([11,1,2,12]))),Q=T({loader:()=>A(()=>import("./RetailersBoost-BAT-AlBq.js"),__vite__mapDeps([13,1,2,12]))}),$=()=>({promoType:"",promoForRetail:!1,userId:U.id,channelId:"",customerId:"",retailerId:"",regionId:"",cityId:"",startDate:"",endDate:"",comments:"",totalSalesBefore:0,totalSalesPlan:0,totalBudgetPlan:0,totalPromoProfitPlan:0,products:[],sellers:[]}),e=H({customers:[],retailers:[],cities:[],channels:[],customerName:"",retailerName:"",promo:$()});let l=H({isForRetail:!1,type:"",title:"",code:""});ne(async()=>{e.promo=$(),await ee()});const X=async a=>{const{data:r}=await b(B.CHANNEL);e.channels=r.channels.filter(o=>o.isForRetail===a.isForRetail)},ee=async()=>{const{data:a}=await b(B.CUSTOMER);e.customers=a.customers};C(()=>e.promo.promoType,async a=>{const r=a;l=G.find(o=>o.type===r),e.promo.promoForRetail=l.isForRetail,e.promo.channelId="",e.promo.customerId="",e.promo.retailerId="",e.promo.regionId="",e.promo.cityId="",e.promo.products=[],e.promo.sellers=[],await X(l)}),C(()=>e.promo.customerId,a=>{if(a!==""){const r=e.customers.find(o=>+o.id==+a);e.promo.regionId=r.region.id,e.promo.cityId=r.city.id,e.promo.products=[],e.promo.sellers=[],e.customerName=r.name,e.promo.retailerId="",e.customers.map(o=>{+o.id==+a&&(e.retailers=o.retailers)})}else e.customerName=a.toString()}),C(()=>e.promo.retailerId,a=>{e.retailerName=a!==""?e.retailerName=e.retailers.find(r=>+r.id==+a).name:a.toString()});const te=(a,r,o,x,E)=>{e.promo.products=a,e.promo.totalSalesBefore=r,e.promo.totalSalesPlan=o,e.promo.totalBudgetPlan=x,e.promo.totalPromoProfitPlan=E},oe=(a,r,o,x)=>{e.promo.sellers=a.filter(E=>(E.salesBefore!==0||E.salesBefore!==null)&&E.salesPlan!==0),e.promo.totalSalesBefore=r,e.promo.totalSalesPlan=o,e.promo.totalBudgetPlan=x},M=()=>l.type==="DISCOUNT"&&e.promo.products.length>0||l.type==="SALES_PEOPLE_BOOST"&&e.promo.sellers.length>0,se=async()=>{const a=await _(B.PROMO,e.promo);a&&a.status==="success"&&(f.clear(),await z.push({name:"Manager.Promo.Index"}))},w=F(()=>R.sortArrayByStringColumn(e.customers,"name")),re=F(()=>R.getUniqueObjectsFromArray(w.value.map(a=>a.region))),le=F(()=>R.getUniqueObjectsFromArray(w.value.map(a=>a.city)));return(a,r)=>(i(),c("div",De,[t("div",Le,[t("div",qe,[Ne,t("div",Ue,[n(he),t("div",$e,[t("div",Me,[n(m,{for:"promo_type",required:""},{default:d(()=>[u("Вид промо-акции")]),_:1}),v(t("select",{"onUpdate:modelValue":r[0]||(r[0]=o=>e.promo.promoType=o),id:"promo_type",class:"form-select"},[Ve,(i(!0),c(h,null,P(s(G),o=>(i(),c("option",{key:o.id,value:o.type},y(o.title),9,He))),128))],512),[[S,e.promo.promoType]])]),t("div",je,[n(m,{for:"user_id"},{default:d(()=>[u("Менеджер")]),_:1}),n(D,{id:"user_id",type:"text",value:s(U).fullName,disabled:"disabled"},null,8,["value"])]),t("div",Ge,[n(m,{for:"channel_id",required:s(l).type!==""},{default:d(()=>[u("Канал продаж")]),_:1},8,["required"]),v(t("select",{"onUpdate:modelValue":r[1]||(r[1]=o=>e.promo.channelId=o),id:"channel_id",class:"form-select",disabled:s(l).type===""},[Ke,(i(!0),c(h,null,P(e.channels,o=>(i(),c("option",{key:o.id,value:o.id},y(o.name),9,ze))),128))],8,We),[[S,e.promo.channelId]])]),t("div",Ye,[n(m,{for:"customer_id",required:s(l).type!==""},{default:d(()=>[u("Дистрибутор")]),_:1},8,["required"]),v(t("select",{"onUpdate:modelValue":r[2]||(r[2]=o=>e.promo.customerId=o),id:"customer_id",class:"form-select",disabled:s(l).type===""},[Je,(i(!0),c(h,null,P(w.value,o=>(i(),c("option",{key:o.id,value:o.id},y(o.name),9,Qe))),128))],8,Ze),[[S,e.promo.customerId]])]),t("div",Xe,[n(m,{for:"retailer_id",required:e.retailers.length>0&&s(l).isForRetail===!0},{default:d(()=>[u("Торговая сеть")]),_:1},8,["required"]),v(t("select",{"onUpdate:modelValue":r[3]||(r[3]=o=>e.promo.retailerId=o),id:"retailer_id",class:"form-select",disabled:e.retailers.length===0||!s(l).isForRetail},[tt,(i(!0),c(h,null,P(e.retailers,o=>(i(),c("option",{key:o.id,value:o.id},y(o.name),9,ot))),128))],8,et),[[S,e.promo.retailerId]])]),t("div",st,[n(m,{for:"region_id",required:""},{default:d(()=>[u("Регион")]),_:1}),v(t("select",{"onUpdate:modelValue":r[4]||(r[4]=o=>e.promo.regionId=o),id:"region_id",class:"form-select",disabled:"disabled"},[rt,(i(!0),c(h,null,P(re.value,o=>(i(),c("option",{key:o.id,value:o.id,selected:e.promo.regionId},y(o.name),9,lt))),128))],512),[[S,e.promo.regionId]])]),t("div",at,[n(m,{for:"city_id",required:""},{default:d(()=>[u("Город")]),_:1}),v(t("select",{"onUpdate:modelValue":r[5]||(r[5]=o=>e.promo.cityId=o),id:"city_id",class:"form-select",disabled:"disabled"},[dt,(i(!0),c(h,null,P(le.value,o=>(i(),c("option",{key:o.id,value:o.id,selected:e.promo.cityId},y(o.name),9,it))),128))],512),[[S,e.promo.cityId]])]),t("div",nt,[n(m,{for:"start_date",required:""},{default:d(()=>[u("Начало промо-акции")]),_:1}),n(D,{id:"start_date",type:"text",readonly:"readonly","aria-describedby":"start_date_help"}),ct]),t("div",ut,[n(m,{for:"end_date",required:""},{default:d(()=>[u("Окончание промо-акции")]),_:1}),n(D,{id:"end_date",type:"text",readonly:"readonly","aria-describedby":"end_date_help"}),_t]),t("div",mt,[n(m,{for:"products",required:s(l).isForRetail===!0},{default:d(()=>[u("Ассортимент для акции")]),_:1},8,["required"]),t("div",pt,[t("input",{id:"products",type:"text",class:"form-control",value:"Ассортимент добавлен?","aria-describedby":"products_help",disabled:!s(l).isForRetail,readonly:""},null,8,ht),s(l).isForRetail===!0?(i(),c(h,{key:0},[e.promo.products.length>0?(i(),c("span",yt,"Да")):(i(),c("span",ft,"Нет"))],64)):p("",!0)]),vt]),t("div",bt,[n(m,{for:"sellers",required:s(l).type==="SALES_PEOPLE_BOOST"},{default:d(()=>[u("Команда ТП")]),_:1},8,["required"]),t("div",gt,[t("input",{id:"sellers",type:"text",class:"form-control",value:"Команда добавлена?","aria-describedby":"sellers_help",disabled:s(l).type!=="SALES_PEOPLE_BOOST",readonly:""},null,8,St),s(l).type==="SALES_PEOPLE_BOOST"?(i(),c(h,{key:0},[e.promo.sellers.length>0?(i(),c("span",Pt,"Да")):(i(),c("span",It,"Нет"))],64)):p("",!0)]),Et]),t("div",Ot,[n(m,{for:"comments"},{default:d(()=>[u("Механика промо-акции")]),_:1}),v(t("textarea",{id:"comments","onUpdate:modelValue":r[6]||(r[6]=o=>e.promo.comments=o),class:"form-control",style:{height:"100px"}},null,512),[[ce,e.promo.comments]])])])]),t("div",kt,[n(q,{onClick:se,class:ue(["btn-primary w-50",{"btn-cursor-not-allowed":!M()}]),disabled:s(g).isButtonDisabled||!M(),loading:s(g).isButtonDisabled},{default:d(()=>[u("Сохранить ")]),_:1},8,["class","disabled","loading"])])])]),t("div",Tt,[s(l).type==="DISCOUNT"?(i(),I(k,{key:0},{default:d(()=>[n(s(Y),{title:s(l).title,"customer-id":+e.promo.customerId,"customer-name":e.customerName,"retailer-name":e.retailerName,onAddProductsToPromo:te},null,8,["title","customer-id","customer-name","retailer-name"])]),fallback:d(()=>[At]),_:1})):p("",!0),s(l).type==="SALES_PEOPLE_BOOST"?(i(),I(k,{key:1},{default:d(()=>[n(s(Z),{title:s(l).title,"customer-id":e.promo.customerId,"customer-name":e.customerName,onAddSellersToPromo:oe},null,8,["title","customer-id","customer-name"])]),fallback:d(()=>[Rt]),_:1})):p("",!0),s(l).type==="GIFT_FOR_PURCHASE"?(i(),I(k,{key:2},{default:d(()=>[n(s(J),{title:s(l).title},null,8,["title"])]),fallback:d(()=>[wt]),_:1})):p("",!0),s(l).type==="RETAILERS_BOOST"?(i(),I(k,{key:3},{default:d(()=>[n(s(Q),{title:s(l).title},null,8,["title"])]),fallback:d(()=>[xt]),_:1})):p("",!0),s(l).type==="COVERAGE_INCREASE"?(i(),I(j(ke),{key:4,title:s(l).title},null,8,["title"])):p("",!0),s(l).type==="IN_OUT"?(i(),I(j(Fe),{key:5,title:s(l).title},null,8,["title"])):p("",!0),s(l).type===""?(i(),c("div",Bt,qt)):p("",!0)])]))}};export{Ht as default};
