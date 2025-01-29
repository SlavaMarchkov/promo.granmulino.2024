import{u as at,a as nt,b as it,d as w,r as L,e as lt,A as E,c as n,f as t,t as d,s as U,y as ct,g as i,w as l,T as I,F as p,h as x,i as _,j as c,k as dt,o,l as rt,m as D,n as _t,p as ut,q as mt,v as ht,x as yt,R,C as M,E as pt,D as vt}from"./app-LDVDDXIB.js";import{u as gt}from"./useHttpService-H3Bhthf8.js";import{u as ft}from"./useArrayHandlers-JXOu8LuP.js";import{_ as bt}from"./TheCheckbox--M688_LN.js";import{_ as wt}from"./InputGroup-DFOwqnPq.js";import{_ as Et}from"./TheFilter-Bt1ein-f.js";import{_ as T}from"./TheBadge-BK2ZTkEW.js";import{_ as H}from"./Modal-Buqgi5Td.js";import{_ as kt,a as V}from"./TdButton-Cll3J42i.js";import{f as St}from"./formatters-k0Na949k.js";const Ct={class:"row mb-4"},At={class:"col-6"},It={class:"mb-0"},xt={class:"col-6 text-end"},Dt={class:"row mb-4"},Rt={class:"col-12"},Vt={class:"col-md-4 mb-2"},$t={class:"col-md-4 mb-2"},Bt={class:"row mb-4"},Lt={class:"col-12"},Ut={class:"card"},Mt={class:"card-body pb-0"},Tt={key:0,class:"table-responsive"},Ht={class:"table table-bordered my-4 text-center align-middle text-nowrap",style:{width:"100%"}},Nt={scope:"row"},Pt={class:"text-start"},Ft={key:1,class:"mt-3 text-center lead"},Ot={class:"fw-bold"},Gt={key:0},Kt={key:1},Yt={class:"row g-3"},qt={class:"col-12"},jt={class:"col-12"},zt={class:"form-check"},Jt=["checked"],Qt=t("label",{class:"form-check-label",for:"is-active"}," Группа товаров в продаже? ",-1),Wt={key:0},Xt={key:1},Zt={key:0},te={class:"bd-callout bd-callout-info"},ee={class:"table table-bordered text-center align-middle text-nowrap",style:{width:"100%"}},se={class:"table-light"},oe=t("th",null,"ID",-1),ae=t("th",{class:"text-start"},"Формат",-1),ne=t("th",null,"Вес, г",-1),ie={key:0},le=t("th",null,"В продаже?",-1),ce={class:"text-start"},de={key:0},re={key:1,class:"bd-callout bd-callout-warning"},_e=t("h5",null,"В группе нет продукции",-1),ue=t("hr",null,null,-1),me=t("p",null,[c("Наполните группу товаров ассортиментом во вкладке "),t("b",null,"Справочники | Ассортимент"),c(".")],-1),he=[_e,ue,me],Ie={__name:"Index",setup(ye){const v=at(),k=nt(),N=it(),u=ft(),{get:P,post:F,update:O,destroy:G}=gt(),S=N.getUser.role,C=w(()=>S===R.SUPER_ADMIN),K=w(()=>C.value?M.concat(pt,vt):M),g=()=>({name:"",isActive:!0}),s=L({categories:[],category:g(),isEditing:!1}),h=L({name:"",isActive:!1});let m=null,y=null;function f(){s.isEditing=!1,s.category=g(),document.activeElement&&document.activeElement.blur()}lt(async()=>{await b(),m=new bootstrap.Modal(document.getElementById("modalPopUp")),m._element.addEventListener("hide.bs.modal",f)});const b=async()=>{const{data:a}=await P(E.CATEGORY,{params:{category_is_active:!1,product_is_active:!0,products:!0}});s.categories=a.categories},$=a=>s.categories.find(r=>r.id===a),Y=()=>{v.clear(),s.isEditing=!1,s.category=g(),m.show()},q=a=>{v.clear(),s.isEditing=!0,s.category=$(a),m.show()},j=a=>{y=new bootstrap.Modal(document.getElementById("viewModalPopUp")),s.category=$(a),y.show(),y._element.addEventListener("hide.bs.modal",f)},z=()=>{m.hide(),m._element.removeEventListener("hide.bs.modal",f)},J=()=>{y.hide(),y._element.removeEventListener("hide.bs.modal",f)},Q=()=>{u.resetSearchKeys(h),u.resetSortKeys()},W=async()=>{if(s.isEditing){const a=await O(`${E.CATEGORY}/${s.category.id}`,s.category);a&&a.status==="success"&&(v.clear(),m.hide(),await b())}else{const a=await F(E.CATEGORY,s.category);a&&a.status==="success"&&(v.clear(),s.category=g(),m.hide(),u.resetSearchKeys(h),u.resetSortKeys("id",!1),await b())}},X=async a=>{if(confirm("Точно удалить группу товаров? Уверены?")){const{status:r}=await G(`${E.CATEGORY}/${a}`);r==="success"&&await b()}},Z=w(()=>u.sortArray(s.categories)),A=w(()=>u.filterArray(Z.value,h));return(a,r)=>{const tt=dt("RouterLink");return o(),n(p,null,[t("div",Ct,[t("div",At,[t("h3",It,d(a.$route.meta.title),1)]),U(t("div",xt,[i(I,{class:"btn-primary",onClick:Y},{default:l(()=>[c("Новая группа товаров ")]),_:1})],512),[[ct,C.value]])]),t("div",Dt,[t("div",Rt,[i(Et,{onResetFilter:Q},{default:l(()=>[t("div",Vt,[i(wt,{modelValue:h.name,"onUpdate:modelValue":r[0]||(r[0]=e=>h.name=e),placeholder:"Поиск по названию группы товаров"},{default:l(()=>[c("Группа товаров ")]),_:1},8,["modelValue"])]),t("div",$t,[i(bt,{id:"is_active",modelValue:h.isActive,"onUpdate:modelValue":r[1]||(r[1]=e=>h.isActive=e)},{default:l(()=>[c("В продаже? ")]),_:1},8,["modelValue"])])]),_:1})])]),t("div",Bt,[t("div",Lt,[t("div",Ut,[t("div",Mt,[A.value.length>0?(o(),n("div",Tt,[t("table",Ht,[t("thead",null,[t("tr",null,[(o(!0),n(p,null,x(K.value,({column:e,label:et,sortable:st,is_num:B,width:ot})=>(o(),rt(kt,{key:e,column:e,"is-numeric":B,"sort-by-asc":_(u).sortBy.asc,"sort-by-column":_(u).sortBy.column===e,sortable:st,width:ot,onSetSort:pe=>_(u).setSort(e,B)},{default:l(()=>[c(d(et),1)]),_:2},1032,["column","is-numeric","sort-by-asc","sort-by-column","sortable","width","onSetSort"]))),128))])]),t("tbody",null,[(o(!0),n(p,null,x(A.value,e=>(o(),n("tr",{key:e.id},[t("th",Nt,d(e.id),1),t("td",Pt,[i(tt,{to:{name:"Category.View",params:{id:e.id}}},{default:l(()=>[c(d(e.name),1)]),_:2},1032,["to"])]),t("td",null,d(e.productsCount),1),t("td",null,[i(T,{"is-active":e.isActive},null,8,["is-active"])]),i(V,{id:e.id,intent:"view",onRunButtonHandler:j},{default:l(()=>[c("View ")]),_:2},1032,["id"]),C.value?(o(),n(p,{key:0},[i(V,{id:e.id,intent:"edit",onRunButtonHandler:q},{default:l(()=>[c("Edit ")]),_:2},1032,["id"]),i(V,{id:e.id,intent:"delete",onRunButtonHandler:X},{default:l(()=>[c("Delete ")]),_:2},1032,["id"])],64)):D("",!0)]))),128))])])])):(o(),n("p",Ft,d(_(k).isLoading?"Подождите, загружаю...":"Записей не найдено..."),1)),t("p",null,[c("Всего записей: "),t("span",Ot,d(A.value.length),1)])])])])]),i(H,{id:"modalPopUp","close-func":z,"custom-classes":[""]},{title:l(()=>[s.isEditing?(o(),n("span",Gt,[c("Редактирование группы товаров "),t("b",null,d(s.category.name),1)])):(o(),n("span",Kt,"Добавление группы товаров"))]),body:l(()=>[i(_t),t("div",Yt,[t("div",qt,[i(ut,{for:"name",required:""},{default:l(()=>[c("Название группы товаров")]),_:1}),i(mt,{id:"name",modelValue:s.category.name,"onUpdate:modelValue":r[2]||(r[2]=e=>s.category.name=e),placeholder:"Например: Granmulino Премиум",type:"text"},null,8,["modelValue"])]),t("div",jt,[t("div",zt,[U(t("input",{id:"is-active","onUpdate:modelValue":r[3]||(r[3]=e=>s.category.isActive=e),checked:s.category.isActive,class:"form-check-input",type:"checkbox"},null,8,Jt),[[ht,s.category.isActive]]),Qt])])])]),footer:l(()=>[i(I,{class:yt([s.isEditing?"btn-warning":"btn-primary","w-25"]),disabled:_(k).isButtonDisabled,loading:_(k).isButtonDisabled,type:"button",onClick:W},{default:l(()=>[s.isEditing?(o(),n("span",Wt,"Сохранить")):(o(),n("span",Xt,"Создать"))]),_:1},8,["class","disabled","loading"])]),_:1}),i(H,{id:"viewModalPopUp","close-func":J,"custom-classes":["modal-dialog-scrollable","modal-lg"]},{title:l(()=>[c(" Просмотр группы товаров "),t("b",null,d(s.category.name),1)]),body:l(()=>[s.category.productsCount>0?(o(),n("div",Zt,[t("div",te,[t("p",null,[c("Кол-во SKU в группе: "),t("strong",null,d(s.category.productsCount),1)])]),t("table",ee,[t("thead",se,[t("tr",null,[oe,ae,ne,_(S)===_(R).PRICE_ADMIN?(o(),n("th",ie,"Цена, руб.")):D("",!0),le])]),t("tbody",null,[(o(!0),n(p,null,x(s.category.products,e=>(o(),n("tr",{key:e.id},[t("td",null,d(e.id),1),t("td",ce,d(e.name),1),t("td",null,d(_(St)(e.weight)),1),_(S)===_(R).PRICE_ADMIN?(o(),n("td",de,d(e.price),1)):D("",!0),t("td",null,[i(T,{"is-active":e.isActive},null,8,["is-active"])])]))),128))])])])):(o(),n("div",re,he))]),footer:l(()=>[i(I,{class:"btn-light"})]),_:1})],64)}}};export{Ie as default};
