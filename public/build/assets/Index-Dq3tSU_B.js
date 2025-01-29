import{d as g,k as S,o as n,l as $,w as r,f as s,t as e,x as f,j as c,i as y,a as A,r as w,e as C,A as M,c as b,g as i,F as V,h as H}from"./app-LDVDDXIB.js";import{u as N}from"./useHttpService-H3Bhthf8.js";import{u as R}from"./useArrayHandlers-JXOu8LuP.js";import{_ as U}from"./TheFilter-Bt1ein-f.js";import{_ as v}from"./SelectGroup-WhYPEgCY.js";import{_ as F}from"./TheCard-DltuzUPB.js";import{a as I}from"./formatters-k0Na949k.js";const P={class:"d-flex w-100 align-items-center"},T={class:"col-md-3"},D={class:"mb-1"},O={class:"col-md-3 text-center"},j={class:"mb-0"},E={class:"col-md-2"},K={class:"mb-0"},q=["innerHTML"],z={class:"mb-0"},G=["innerHTML"],J={class:"col-md-2 text-center"},Q={class:"mb-0"},W={class:"col-md-2 text-center"},X={class:"mb-0"},Y={__name:"AdminPromoItem",props:{promo:{type:Object,required:!0}},setup(k){const o=k,_=g(()=>o.promo.totalMark>0&&o.promo.totalMark<=3?"bg-danger":o.promo.totalMark>3&&o.promo.totalMark<=5?"bg-success":"bg-secondary");return(p,d)=>{const u=S("RouterLink");return n(),$(u,{to:{name:"Promo.View",params:{id:o.promo.id}},class:"list-group-item list-group-item-action promo-item"},{default:r(()=>[s("div",P,[s("div",T,[s("h5",D,e(o.promo.customerName)+" | "+e(o.promo.retailerName),1),s("small",null,e(o.promo.startDate)+" - "+e(o.promo.endDate),1)]),s("div",O,[s("h5",j,[s("span",{class:f(["badge",o.promo.statusColor])},e(o.promo.statusLabel),3)])]),s("div",E,[s("p",K,[c("Бюджет, факт: "),s("span",{class:"fw-bold",innerHTML:y(I)(o.promo.totalBudgetActual)},null,8,q)]),s("p",z,[c("Бюджет, план: "),s("span",{class:"fw-bold",innerHTML:y(I)(o.promo.totalBudgetPlan)},null,8,G)])]),s("div",J,[s("h5",Q,[s("span",{class:f(["badge",o.promo.promoBgColor])},e(o.promo.promoCode)+" - "+e(o.promo.promoLabel),3)])]),s("div",W,[s("h4",X,[s("span",{class:f(["badge",_.value])},e(o.promo.totalMark),3)])])])]),_:1},8,["to"])}}},Z={class:"row mb-4"},ss={class:"col-12"},os={class:"mb-0"},es={class:"row mb-4"},ts={class:"col-12"},as={class:"col-md-4 mb-2"},rs={class:"col-md-4 mb-2"},ls={class:"col-md-4 mb-2"},ns={class:"row mb-4"},cs={class:"col-12"},ds={class:"mb-0"},ms={class:"list-group"},is={class:"mb-0"},_s={class:"fw-bold"},ps={key:1,class:"mt-3 text-center lead"},ys={__name:"Index",setup(k){const o=R(),_=A(),{get:p}=N(),d=w({promos:[]});C(async()=>{await u(),await x()});const u=async()=>{const{data:m}=await p(M.PROMO);d.promos=m.promos},x=async()=>{const{data:m}=await p(M.USER,{params:{is_active:!0}});d.users=m.users},t=w({userId:""}),L=()=>{o.resetSearchKeys(t),o.resetSortKeys()},B=g(()=>o.sortArray(d.promos)),h=g(()=>o.filterArray(B.value,t));return(m,l)=>(n(),b(V,null,[s("div",Z,[s("div",ss,[s("h3",os,e(m.$route.meta.title),1)])]),s("div",es,[s("div",ts,[i(U,{onResetFilter:L},{default:r(()=>[s("div",as,[i(v,{modelValue:t.userId,"onUpdate:modelValue":l[0]||(l[0]=a=>t.userId=a),chooseFrom:"-- Выберите менеджера --",items:d.users,selectedOption:"fullName"},{default:r(()=>[c("Менеджер ")]),_:1},8,["modelValue","items"])]),s("div",rs,[i(v,{modelValue:t.userId,"onUpdate:modelValue":l[1]||(l[1]=a=>t.userId=a),chooseFrom:"-- Выберите статус --"},{default:r(()=>[c("Статус ")]),_:1},8,["modelValue"])]),s("div",ls,[i(v,{modelValue:t.userId,"onUpdate:modelValue":l[2]||(l[2]=a=>t.userId=a),chooseFrom:"-- Выберите тип акции --"},{default:r(()=>[c("Тип акции ")]),_:1},8,["modelValue"])])]),_:1})])]),s("div",ns,[s("div",cs,[h.value.length>0?(n(),$(F,{key:0,"with-footer":""},{header:r(()=>[s("h4",ds,"Список промо-акций "+e(t),1)]),body:r(()=>[s("div",ms,[(n(!0),b(V,null,H(h.value,a=>(n(),$(Y,{key:a.id,promo:a},null,8,["promo"]))),128))])]),footer:r(()=>[s("p",is,[c("Всего записей: "),s("span",_s,e(h.value.length),1)])]),_:1})):(n(),b("p",ps,e(y(_).isLoading?"Подождите, загружаю...":"Записей не найдено..."),1))])])],64))}};export{ys as default};
