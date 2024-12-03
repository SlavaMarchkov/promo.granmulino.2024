import{u as _e,a as pe,b as fe,d as V,r as D,e as he,A as p,c,f as e,g as n,w as l,F as f,h as y,t as d,i as h,j as a,k as ve,o as r,l as L,m as T,n as be,p as v,q as ye,s as g,H as x,T as F,x as H,L as ge,v as we,R as Ie,M as N,E as O,D as Ee}from"./app-CvDqXEOd.js";import{u as Se}from"./useHttpService-Cv4QBHm9.js";import{u as Ve}from"./useArrayHandlers-Dmi2z74m.js";import{_ as ke,a as M}from"./TdButton-DoOWIy6T.js";import{_ as P}from"./TheBadge-BBHb-MvK.js";import{_ as Ue,a as q}from"./TheFilter-VzPJfpVU.js";import{_ as K}from"./SelectGroup-BYhVyxVb.js";import{_ as Ce}from"./TheCheckbox-D3tzlK-V.js";import{_ as j}from"./Modal-BjKEkhVV.js";const xe={class:"row mb-2"},Me={class:"col-12"},Re={class:"col-md-4 mb-2"},Ae={class:"col-md-4 mb-2"},$e={class:"col-md-4 mb-2"},Be={class:"col-md-4 mb-2"},De={class:"col-md-4 mb-2"},Le={class:"row mb-4"},Te={class:"col-12"},Fe={class:"card"},He={class:"card-body pb-0"},Ne={key:0,class:"table-responsive"},Oe={class:"table table-bordered my-4 text-center align-middle text-nowrap",style:{width:"100%"}},Pe={scope:"row"},qe={class:"text-start"},Ke={class:"text-start"},je={class:"text-start"},ze={class:"text-start"},Ge={key:1,class:"mt-3 text-center lead"},Je={class:"fw-bold"},Qe={key:0},We=e("br",null,null,-1),Xe={key:1},Ye={class:"row g-3"},Ze={class:"col-12"},et={class:"col-12"},tt=e("option",{disabled:"",selected:"",value:"null"},"-- Выберите регион --",-1),st=["value"],ot={key:0,class:"col-12"},lt=e("option",{disabled:"",selected:"",value:"null"},"-- Выберите город --",-1),it=["value"],nt={class:"col-6"},at=e("option",{disabled:"",selected:"",value:"null"},"-- Выберите ФИО --",-1),dt=["value"],rt={class:"col-6"},ct={class:"col-12"},ut={class:"col-12"},mt={class:"form-check"},_t=["checked"],pt=e("label",{class:"form-check-label",for:"is-active"}," Активный? ",-1),ft={key:0},ht={key:1},vt={class:"table table-bordered mt-3 align-middle text-wrap",style:{width:"100%"}},bt=e("th",{style:{width:"20%"}},"ID",-1),yt=e("th",null,"Название",-1),gt=e("th",null,"Регион",-1),wt=e("th",null,"Город",-1),It=e("th",null,"Менеджер",-1),Et=e("th",null,"Активен?",-1),St=e("th",null,"Описание",-1),Vt=e("span",null,null,-1),Tt={__name:"Index",setup(kt){const w=_e(),k=pe(),z=fe(),m=Ve(),{get:U,post:G,update:J,destroy:Q}=Se(),W=z.getUser.role,R=V(()=>W===Ie.SUPER_ADMIN),X=V(()=>R?N.concat(O,Ee):N.concat(O)),I=()=>({name:"",description:"",isActive:!0,regionId:null,cityId:null,userId:null}),t=D({customers:[],users:[],regions:[],cities:[],customer:I(),isEditing:!1}),u=D({name:"",userId:"",regionId:"",city:"",isActive:!1});let _=null,b=null;function E(){t.isEditing=!1,t.customer=I()}he(async()=>{await S(),await Z(),await Y(),_=new bootstrap.Modal(document.getElementById("modalPopUp")),_._element.addEventListener("hide.bs.modal",E)});const S=async()=>{const{data:i}=await U(p.CUSTOMER);t.customers=i.customers},A=i=>t.customers.find(o=>o.id===i),Y=async()=>{const{data:i}=await U(p.REGION);t.regions=i.regions},Z=async()=>{const{data:i}=await U(p.USER,{params:{is_active:!0}});t.users=i.users},$=()=>{t.regions.map(i=>{+i.id==+t.customer.regionId&&(t.cities=i.cities)})},ee=()=>{w.clear(),t.isEditing=!1,t.cities=[],t.customer=I(),_.show()},te=i=>{w.clear(),t.isEditing=!0,t.customer=A(i),$(t.customer.regionId),_.show()},se=i=>{b=new bootstrap.Modal(document.getElementById("viewModalPopUp")),t.customer=A(i),b.show(),b._element.addEventListener("hide.bs.modal",E)},oe=()=>{_.hide(),_._element.removeEventListener("hide.bs.modal",E)},le=()=>{b.hide(),b._element.removeEventListener("hide.bs.modal",E)},ie=()=>{m.resetSearchKeys(u),m.resetSortKeys()},ne=async()=>{if(t.isEditing){const i=await J(`${p.CUSTOMER}/${t.customer.id}`,t.customer);i&&i.status==="success"&&(w.clear(),_.hide(),await S())}else{const i=await G(p.CUSTOMER,t.customer);i&&i.status==="success"&&(w.clear(),t.customer=I(),_.hide(),m.resetSearchKeys(u),m.resetSortKeys("id",!1),await S())}},ae=async i=>{if(confirm("Точно удалить контрагента? Уверены?")){const o=await Q(`${p.CUSTOMER}/${i}`);o&&o.status==="success"&&await S()}},de=V(()=>m.sortArray(t.customers)),C=V(()=>m.filterArray(de.value,u));return(i,o)=>{const re=ve("RouterLink");return r(),c(f,null,[e("div",{class:"row mb-4"},[e("div",{class:"col-12"},[e("button",{onClick:ee,class:"btn btn-primary",type:"button"}," Новый контрагент ")])]),e("div",xe,[e("div",Me,[n(Ue,{onResetFilter:ie},{default:l(()=>[e("div",Re,[n(q,{modelValue:u.name,"onUpdate:modelValue":o[0]||(o[0]=s=>u.name=s),placeholder:"Поиск по названию"},{default:l(()=>[a(" Клиент ")]),_:1},8,["modelValue"])]),e("div",Ae,[n(K,{modelValue:u.userId,"onUpdate:modelValue":o[1]||(o[1]=s=>u.userId=s),chooseFrom:"-- Выберите менеджера --",items:t.users,selectedOption:"fullName"},{default:l(()=>[a("Менеджер ")]),_:1},8,["modelValue","items"])]),e("div",$e,[n(K,{modelValue:u.regionId,"onUpdate:modelValue":o[2]||(o[2]=s=>u.regionId=s),chooseFrom:"-- Выберите регион --",items:t.regions},{default:l(()=>[a("Регион ")]),_:1},8,["modelValue","items"])]),e("div",Be,[n(q,{modelValue:u.city,"onUpdate:modelValue":o[3]||(o[3]=s=>u.city=s),placeholder:"Поиск по городу"},{default:l(()=>[a(" Город ")]),_:1},8,["modelValue"])]),e("div",De,[n(Ce,{id:"is_active",modelValue:u.isActive,"onUpdate:modelValue":o[4]||(o[4]=s=>u.isActive=s)},{default:l(()=>[a(" Показать только активных ")]),_:1},8,["modelValue"])])]),_:1})])]),e("div",Le,[e("div",Te,[e("div",Fe,[e("div",He,[C.value.length>0?(r(),c("div",Ne,[e("table",Oe,[e("thead",null,[e("tr",null,[(r(!0),c(f,null,y(X.value,({column:s,label:ce,sortable:ue,is_num:B,width:me})=>(r(),L(ke,{key:s,column:s,"is-numeric":B,"sort-by-asc":h(m).sortBy.asc,"sort-by-column":h(m).sortBy.column===s,sortable:ue,width:me,onSetSort:Ut=>h(m).setSort(s,B)},{default:l(()=>[a(d(ce),1)]),_:2},1032,["column","is-numeric","sort-by-asc","sort-by-column","sortable","width","onSetSort"]))),128))])]),e("tbody",null,[(r(!0),c(f,null,y(C.value,s=>(r(),c("tr",{key:s.id},[e("th",Pe,d(s.id),1),e("td",qe,[n(re,{to:{name:"Customer.View",params:{id:s.id}}},{default:l(()=>[a(d(s.name),1)]),_:2},1032,["to"])]),e("td",Ke,d(s.user),1),e("td",je,d(s.region),1),e("td",ze,d(s.city),1),e("td",null,[n(P,{"is-active":s.isActive},null,8,["is-active"])]),n(M,{id:s.id,intent:"view",onRunButtonHandler:se},{default:l(()=>[a("View ")]),_:2},1032,["id"]),n(M,{id:s.id,intent:"edit",onRunButtonHandler:te},{default:l(()=>[a("Edit ")]),_:2},1032,["id"]),R.value?(r(),L(M,{key:0,id:s.id,intent:"delete",onRunButtonHandler:ae},{default:l(()=>[a("Delete ")]),_:2},1032,["id"])):T("",!0)]))),128))])])])):(r(),c("p",Ge,d(h(k).isLoading?"Подождите, загружаю...":"Записей не найдено..."),1)),e("p",null,[a("Всего записей: "),e("span",Je,d(C.value.length),1)])])])])]),n(j,{id:"modalPopUp","close-func":oe,"custom-classes":[""]},{title:l(()=>[t.isEditing?(r(),c("span",Qe,[a("Редактирование контрагента "),We,e("b",null,d(t.customer.name),1)])):(r(),c("span",Xe,"Добавление контрагента"))]),body:l(()=>[n(be),e("div",Ye,[e("div",Ze,[n(v,{for:"name",required:""},{default:l(()=>[a("Название контрагента")]),_:1}),n(ye,{modelValue:t.customer.name,"onUpdate:modelValue":o[5]||(o[5]=s=>t.customer.name=s),type:"text",id:"name",placeholder:"Например: Уральская Бакалея, ООО"},null,8,["modelValue"])]),e("div",et,[n(v,{for:"region_id",required:""},{default:l(()=>[a("Регион")]),_:1}),g(e("select",{"onUpdate:modelValue":o[6]||(o[6]=s=>t.customer.regionId=s),onChange:o[7]||(o[7]=s=>{$(),t.customer.cityId=null}),id:"region_id",class:"form-select"},[tt,(r(!0),c(f,null,y(t.regions,s=>(r(),c("option",{value:s.id,key:s.id},d(s.name),9,st))),128))],544),[[x,t.customer.regionId]])]),t.customer.regionId?(r(),c("div",ot,[n(v,{for:"city_id",required:""},{default:l(()=>[a("Город")]),_:1}),g(e("select",{"onUpdate:modelValue":o[8]||(o[8]=s=>t.customer.cityId=s),id:"city_id",class:"form-select"},[lt,(r(!0),c(f,null,y(t.cities,s=>(r(),c("option",{value:s.id,key:s.id},d(s.name),9,it))),128))],512),[[x,t.customer.cityId]])])):T("",!0),e("div",nt,[n(v,{for:"user_id"},{default:l(()=>[a("Менеджер для контрагента")]),_:1}),g(e("select",{id:"user_id","onUpdate:modelValue":o[9]||(o[9]=s=>t.customer.userId=s),class:"form-select"},[at,(r(!0),c(f,null,y(t.users,s=>(r(),c("option",{key:s.id,value:s.id},d(s.fullName),9,dt))),128))],512),[[x,t.customer.userId]])]),e("div",rt,[n(v,null,{default:l(()=>[a("Сброс привязки менеджера")]),_:1}),n(F,{onClick:o[10]||(o[10]=s=>t.customer.userId=null),type:"button",class:H(["btn-light",{"btn-disabled":t.customer.userId===null}]),disabled:t.customer.userId===null},{default:l(()=>[a(" Сбросить ")]),_:1},8,["class","disabled"])]),e("div",ct,[n(v,{for:"description"},{default:l(()=>[a("Описание для контрагента")]),_:1}),g(e("textarea",{id:"description","onUpdate:modelValue":o[11]||(o[11]=s=>t.customer.description=s),class:"form-control",placeholder:"Укажите произвольное описание"},null,512),[[ge,t.customer.description]])]),e("div",ut,[e("div",mt,[g(e("input",{id:"is-active","onUpdate:modelValue":o[12]||(o[12]=s=>t.customer.isActive=s),checked:t.customer.isActive,class:"form-check-input",type:"checkbox"},null,8,_t),[[we,t.customer.isActive]]),pt])])])]),footer:l(()=>[n(F,{onClick:ne,type:"button",loading:h(k).isButtonDisabled,disabled:h(k).isButtonDisabled,class:H(["w-25",t.isEditing?"btn-warning":"btn-primary"])},{default:l(()=>[t.isEditing?(r(),c("span",ft,"Сохранить")):(r(),c("span",ht,"Создать"))]),_:1},8,["loading","disabled","class"])]),_:1}),n(j,{id:"viewModalPopUp","close-func":le,"custom-classes":["modal-lg","modal-dialog-scrollable"]},{title:l(()=>[a(" Просмотр контрагента "),e("b",null,d(t.customer.name),1)]),body:l(()=>[e("table",vt,[e("tbody",null,[e("tr",null,[bt,e("td",null,d(t.customer.id),1)]),e("tr",null,[yt,e("td",null,d(t.customer.name),1)]),e("tr",null,[gt,e("td",null,d(t.customer.region),1)]),e("tr",null,[wt,e("td",null,d(t.customer.city),1)]),e("tr",null,[It,e("td",null,d(t.customer.user),1)]),e("tr",null,[Et,e("td",null,[n(P,{"is-active":t.customer.isActive},null,8,["is-active"])])]),e("tr",null,[St,e("td",null,d(t.customer.description),1)])])])]),footer:l(()=>[Vt]),_:1})],64)}}};export{Tt as default};
