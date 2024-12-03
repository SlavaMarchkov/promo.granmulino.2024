import{d as k,o as d,c,f as e,S as _e,u as me,a as pe,b as he,r as N,e as ve,A as f,g as o,w as i,F as y,h as E,t as r,i as h,j as n,k as fe,V as ye,l as q,x as K,m as be,n as we,p as V,q as ge,s as b,H as $,L as Ee,v as O,T as Ve,R as ke,W as z,E as Y,D as Se}from"./app-CvDqXEOd.js";import{u as Re}from"./useHttpService-Cv4QBHm9.js";import{u as Ie}from"./useArrayHandlers-Dmi2z74m.js";import{_ as j}from"./TheCheckbox-D3tzlK-V.js";import{_ as De,a as T}from"./TheFilter-VzPJfpVU.js";import{_ as Ae,a as B}from"./TdButton-DoOWIy6T.js";import{_ as D}from"./TheBadge-BBHb-MvK.js";import{_ as W}from"./Modal-BjKEkhVV.js";const Ue={class:"input-group"},xe={class:"input-group-text"},Le=["id","name","value","checked"],$e=["for"],Te={__name:"RadioButton",props:{id:String,name:String,modelValue:{type:String,default:""},value:{type:String,default:""}},emits:["update:modelValue"],setup(C,{emit:v}){const _=C,A=v,m=()=>{A("update:modelValue",_.value)},w=k(()=>_.modelValue===_.value);return(U,M)=>(d(),c("div",Ue,[e("div",xe,[e("input",{id:_.id,name:_.name,value:_.value,checked:w.value,class:"form-check-input mt-0",type:"radio",onChange:m},null,40,Le)]),e("label",{for:_.id,class:"form-control text-start"},[_e(U.$slots,"default")],8,$e)]))}},Be={class:"row mb-2"},Ce={class:"col-12"},Me={class:"col-md-4 mb-2"},He={class:"col-md-4 mb-2"},Pe={class:"col-md-4 mb-2"},Fe={class:"col-md-2 mb-2"},Ne={class:"col-md-2 mb-2"},qe={class:"row mb-4"},Ke={class:"col-12"},Oe={class:"card"},ze={class:"card-body pb-0"},Ye={key:0,class:"table-responsive"},je={class:"table table-bordered my-4 text-center align-middle text-nowrap",style:{width:"100%"}},We={scope:"row"},Ge={class:"text-start"},Je={class:"text-start"},Qe=["title"],Xe={class:"text-start"},Ze={class:"text-start"},et={key:1,class:"mt-3 text-center lead"},tt={class:"fw-bold"},st={key:0},lt=e("br",null,null,-1),ot={key:1},it={class:"row g-3"},at={class:"col-12"},nt={class:"col-12"},dt=e("option",{disabled:"",selected:"",value:"null"},"-- Выберите дистрибутора, который поставляет в эту ТС -- ",-1),rt=["value"],ct={class:"col-12"},ut=e("option",{disabled:"",selected:"",value:""},"-- Выберите тип торговой сети --",-1),_t=e("option",{value:"local"},"Локальная",-1),mt=e("option",{value:"regional"},"Региональная",-1),pt=e("option",{value:"federal"},"Федеральная",-1),ht=[ut,_t,mt,pt],vt={class:"col-12"},ft=e("option",{disabled:"",selected:"",value:"null"},"-- Выберите город, где находится штаб-квартира ТС -- ",-1),yt=["value"],bt={class:"col-12"},wt={class:"col-12"},gt={class:"form-check"},Et=["checked"],Vt=e("label",{class:"form-check-label",for:"is-direct"}," Прямой контракт (да/нет) ",-1),kt={class:"col-12"},St={class:"form-check"},Rt=["checked"],It=e("label",{class:"form-check-label",for:"is-active"}," ТС активная (да/нет) ",-1),Dt={key:0},At={key:1},Ut={class:"table table-bordered mt-3 align-middle text-wrap",style:{width:"100%"}},xt=e("th",{style:{width:"30%"}},"ID",-1),Lt=e("th",null,"Название",-1),$t=e("th",null,"Контрагент",-1),Tt=e("th",null,"Город",-1),Bt=e("th",null,"Прямой контракт?",-1),Ct=e("th",null,"Активна?",-1),Mt=e("th",null,"Описание",-1),Ht=e("span",null,null,-1),Wt={__name:"Index",setup(C){const v=me(),_=pe(),A=he(),m=Ie(),{get:w,post:U,update:M,destroy:G}=Re(),J=A.getUser.role,H=k(()=>J===ke.SUPER_ADMIN),Q=k(()=>H?z.concat(Y,Se):z.concat(Y)),S=()=>({name:"",type:"",description:"",isActive:!0,isDirect:!1,customerId:null,cityId:null}),s=N({retailers:[],customers:[],cities:[],retailer:S(),isEditing:!1}),u=N({name:"",city:"",customer:"",type:"",isActive:!1,isDirect:!1});let p=null,g=null;function R(){s.isEditing=!1,s.retailer=S()}ve(async()=>{await I(),await X(),await Z(),p=new bootstrap.Modal(document.getElementById("modalPopUp")),p._element.addEventListener("hide.bs.modal",R)});const I=async()=>{const{data:a}=await w(f.RETAILER);s.retailers=a.retailers},P=a=>s.retailers.find(l=>l.id===a),X=async()=>{const{data:a}=await w(f.CUSTOMER);s.customers=a.customers},Z=async()=>{const{data:a}=await w(f.CITY);s.cities=a.cities},ee=()=>{v.clear(),s.isEditing=!1,s.retailer=S(),p.show()},te=a=>{v.clear(),s.isEditing=!0,s.retailer=P(a),p.show()},se=a=>{g=new bootstrap.Modal(document.getElementById("viewModalPopUp")),s.retailer=P(a),g.show(),g._element.addEventListener("hide.bs.modal",R)},le=()=>{p.hide(),p._element.removeEventListener("hide.bs.modal",R)},oe=()=>{g.hide(),g._element.removeEventListener("hide.bs.modal",R)},ie=()=>{m.resetSearchKeys(u),m.resetSortKeys()},ae=async()=>{if(s.isEditing){const a=await M(`${f.RETAILER}/${s.retailer.id}`,s.retailer);a&&a.status==="success"&&(v.clear(),p.hide(),await I())}else{const a=await U(f.RETAILER,s.retailer);a&&a.status==="success"&&(v.clear(),s.retailer=S(),p.hide(),m.resetSearchKeys(u),m.resetSortKeys("id",!1),await I())}},ne=async a=>{if(confirm("Точно удалить торговую сеть? Уверены?")){const l=await G(`${f.RETAILER}/${a}`);l&&l.status==="success"&&await I()}},de=k(()=>m.sortArray(s.retailers)),x=k(()=>m.filterArray(de.value,u));return(a,l)=>{const re=fe("RouterLink");return d(),c(y,null,[e("div",{class:"row mb-4"},[e("div",{class:"col-12"},[e("button",{class:"btn btn-primary",type:"button",onClick:ee}," Новая торговая сеть ")])]),e("div",Be,[e("div",Ce,[o(De,{onResetFilter:ie},{default:i(()=>[e("div",Me,[o(T,{modelValue:u.name,"onUpdate:modelValue":l[0]||(l[0]=t=>u.name=t),placeholder:"Поиск по названию ТС"},{default:i(()=>[n("Название")]),_:1},8,["modelValue"])]),(d(!0),c(y,null,E(h(ye),t=>(d(),c("div",{class:"col-md-2 mb-2",key:t.id},[o(Te,{id:t.id,value:t.value,name:"retailer-type",modelValue:u.type,"onUpdate:modelValue":l[1]||(l[1]=L=>u.type=L)},{default:i(()=>[n(r(t.title),1)]),_:2},1032,["id","value","modelValue"])]))),128)),e("div",He,[o(T,{modelValue:u.city,"onUpdate:modelValue":l[2]||(l[2]=t=>u.city=t),placeholder:"Поиск по городу"},{default:i(()=>[n("Город")]),_:1},8,["modelValue"])]),e("div",Pe,[o(T,{modelValue:u.customer,"onUpdate:modelValue":l[3]||(l[3]=t=>u.customer=t),placeholder:"Поиск по контрагенту"},{default:i(()=>[n("Контрагент")]),_:1},8,["modelValue"])]),e("div",Fe,[o(j,{id:"is_active",modelValue:u.isActive,"onUpdate:modelValue":l[4]||(l[4]=t=>u.isActive=t)},{default:i(()=>[n("Только активные")]),_:1},8,["modelValue"])]),e("div",Ne,[o(j,{id:"is_direct",modelValue:u.isDirect,"onUpdate:modelValue":l[5]||(l[5]=t=>u.isDirect=t)},{default:i(()=>[n("Только прямые")]),_:1},8,["modelValue"])])]),_:1})])]),e("div",qe,[e("div",Ke,[e("div",Oe,[e("div",ze,[x.value.length>0?(d(),c("div",Ye,[e("table",je,[e("thead",null,[e("tr",null,[(d(!0),c(y,null,E(Q.value,({column:t,label:L,sortable:ce,is_num:F,width:ue})=>(d(),q(Ae,{key:t,column:t,"is-numeric":F,"sort-by-asc":h(m).sortBy.asc,"sort-by-column":h(m).sortBy.column===t,sortable:ce,width:ue,onSetSort:Pt=>h(m).setSort(t,F)},{default:i(()=>[n(r(L),1)]),_:2},1032,["column","is-numeric","sort-by-asc","sort-by-column","sortable","width","onSetSort"]))),128))])]),e("tbody",null,[(d(!0),c(y,null,E(x.value,t=>(d(),c("tr",{key:t.id},[e("th",We,r(t.id),1),e("td",Ge,[o(re,{to:{name:"Retailer.View",params:{id:t.id}}},{default:i(()=>[n(r(t.name),1)]),_:2},1032,["to"])]),e("td",Je,[e("span",{class:K(["badge","bg-opacity-75",t.typeBgColor]),title:t.typeDescription,style:{"font-size":"0.8em"}},r(t.label),11,Qe)]),e("td",Xe,r(t.customer),1),e("td",Ze,r(t.city),1),e("td",null,[o(D,{"is-active":t.isDirect},null,8,["is-active"])]),e("td",null,[o(D,{"is-active":t.isActive},null,8,["is-active"])]),o(B,{id:t.id,intent:"view",onRunButtonHandler:se},{default:i(()=>[n("View ")]),_:2},1032,["id"]),o(B,{id:t.id,intent:"edit",onRunButtonHandler:te},{default:i(()=>[n("Edit ")]),_:2},1032,["id"]),H.value?(d(),q(B,{key:0,id:t.id,intent:"delete",onRunButtonHandler:ne},{default:i(()=>[n("Delete ")]),_:2},1032,["id"])):be("",!0)]))),128))])])])):(d(),c("p",et,r(h(_).isLoading?"Подождите, загружаю...":"Записей не найдено..."),1)),e("p",null,[n("Всего записей: "),e("span",tt,r(x.value.length),1)])])])])]),o(W,{id:"modalPopUp","close-func":le,"custom-classes":[""]},{title:i(()=>[s.isEditing?(d(),c("span",st,[n("Редактирование торговой сети "),lt,e("b",null,r(s.retailer.name),1)])):(d(),c("span",ot,"Добавление торговой сети"))]),body:i(()=>[o(we),e("div",it,[e("div",at,[o(V,{for:"name",required:""},{default:i(()=>[n("Название торговой сети")]),_:1}),o(ge,{id:"name",modelValue:s.retailer.name,"onUpdate:modelValue":l[6]||(l[6]=t=>s.retailer.name=t),placeholder:"Например: Пятёрочка",type:"text"},null,8,["modelValue"])]),e("div",nt,[o(V,{for:"customer_id",required:""},{default:i(()=>[n("Контрагент")]),_:1}),b(e("select",{id:"customer_id","onUpdate:modelValue":l[7]||(l[7]=t=>s.retailer.customerId=t),class:"form-select"},[dt,(d(!0),c(y,null,E(s.customers,t=>(d(),c("option",{key:t.id,value:t.id},r(t.name),9,rt))),128))],512),[[$,s.retailer.customerId]])]),e("div",ct,[o(V,{for:"type",required:""},{default:i(()=>[n("Тип торговой сети")]),_:1}),b(e("select",{id:"type","onUpdate:modelValue":l[8]||(l[8]=t=>s.retailer.type=t),class:"form-select"},ht,512),[[$,s.retailer.type]])]),e("div",vt,[o(V,{for:"city_id",required:""},{default:i(()=>[n("Город")]),_:1}),b(e("select",{id:"city_id","onUpdate:modelValue":l[9]||(l[9]=t=>s.retailer.cityId=t),class:"form-select"},[ft,(d(!0),c(y,null,E(s.cities,t=>(d(),c("option",{key:t.id,value:t.id},r(t.name),9,yt))),128))],512),[[$,s.retailer.cityId]])]),e("div",bt,[o(V,{for:"description"},{default:i(()=>[n("Описание для торговой сети")]),_:1}),b(e("textarea",{id:"description","onUpdate:modelValue":l[10]||(l[10]=t=>s.retailer.description=t),class:"form-control",placeholder:"Укажите произвольное описание"},null,512),[[Ee,s.retailer.description]])]),e("div",wt,[e("div",gt,[b(e("input",{id:"is-direct","onUpdate:modelValue":l[11]||(l[11]=t=>s.retailer.isDirect=t),checked:s.retailer.isDirect,class:"form-check-input",type:"checkbox"},null,8,Et),[[O,s.retailer.isDirect]]),Vt])]),e("div",kt,[e("div",St,[b(e("input",{id:"is-active","onUpdate:modelValue":l[12]||(l[12]=t=>s.retailer.isActive=t),checked:s.retailer.isActive,class:"form-check-input",type:"checkbox"},null,8,Rt),[[O,s.retailer.isActive]]),It])])])]),footer:i(()=>[o(Ve,{class:K([s.isEditing?"btn-warning":"btn-primary","w-25"]),disabled:h(_).isButtonDisabled,loading:h(_).isButtonDisabled,type:"button",onClick:ae},{default:i(()=>[s.isEditing?(d(),c("span",Dt,"Сохранить")):(d(),c("span",At,"Создать"))]),_:1},8,["class","disabled","loading"])]),_:1}),o(W,{id:"viewModalPopUp","close-func":oe,"custom-classes":["modal-lg","modal-dialog-scrollable"]},{title:i(()=>[n(" Просмотр торговой сети "),e("b",null,r(s.retailer.name),1)]),body:i(()=>[e("table",Ut,[e("tbody",null,[e("tr",null,[xt,e("td",null,r(s.retailer.id),1)]),e("tr",null,[Lt,e("td",null,r(s.retailer.name),1)]),e("tr",null,[$t,e("td",null,r(s.retailer.customer),1)]),e("tr",null,[Tt,e("td",null,r(s.retailer.city),1)]),e("tr",null,[Bt,e("td",null,[o(D,{"is-active":s.retailer.isDirect},null,8,["is-active"])])]),e("tr",null,[Ct,e("td",null,[o(D,{"is-active":s.retailer.isActive},null,8,["is-active"])])]),e("tr",null,[Mt,e("td",null,r(s.retailer.description),1)])])])]),footer:i(()=>[Ht]),_:1})],64)}}};export{Wt as default};
