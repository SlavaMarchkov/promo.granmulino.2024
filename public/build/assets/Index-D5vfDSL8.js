import{a as w,r as b,e as k,a1 as y,c as i,F as u,h as v,f as a,t as s,i as d,j as o,k as x,o as r,l as N,w as e,x as B,g as l}from"./app-BPdZrYo3.js";import{u as L}from"./useHttpService-BNZ4gPHT.js";import{_ as n,a as S}from"./TwoColumnRow-DgtO-1NF.js";import{f as m}from"./formatters-hPmLyB9N.js";const C={key:0,class:"row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3"},R={class:"mb-0"},M={class:"mb-0"},P=a("hr",null,null,-1),V={key:1,class:"row mb-4"},A={class:"col-12"},D={class:"mt-3 lead"},$={class:"row my-4"},E={class:"col-12"},F={class:"fw-bold"},T={__name:"Index",setup(O){const f=w(),{get:h}=L(),c=b({promos:[]});k(async()=>{await p()});const p=async()=>{const{data:_}=await h(y.PROMO,{params:{customer:!0,retailer:!0}});c.promos=_.promos};return(_,j)=>{const g=x("RouterLink");return r(),i(u,null,[c.promos.length>0?(r(),i("div",C,[(r(!0),i(u,null,v(c.promos,t=>(r(),N(S,{key:t.id,"header-classes":["bg-light"],"with-footer":""},{header:e(()=>[a("h3",R,s(t.promoCode)+s(t.discount!==null?`-${t.discount}`:""),1),a("h4",M,[a("span",{class:B(["badge",t.statusColor])},s(t.statusLabel),3)])]),body:e(()=>[l(n,{title:"Дистрибутор"},{default:e(()=>[o(s(t.customerName),1)]),_:2},1024),l(n,{title:"Торговая сеть"},{default:e(()=>[o(s(t.retailerName),1)]),_:2},1024),l(n,{title:"Дата начала"},{default:e(()=>[o(s(t.startDate),1)]),_:2},1024),l(n,{title:"Дата окончания"},{default:e(()=>[o(s(t.endDate),1)]),_:2},1024),P,l(n,{class:"fs-5",title:"Бюджет, план"},{default:e(()=>[o(s(d(m)(t.totalBudgetPlan))+" руб. ",1)]),_:2},1024),l(n,{class:"fs-5",title:"Бюджет, факт"},{default:e(()=>[o(s(d(m)(t.totalBudgetActual))+" руб. ",1)]),_:2},1024)]),footer:e(()=>[l(g,{to:{name:"Manager.Promo.View",params:{id:t.id}},class:"btn btn-outline-primary"},{default:e(()=>[o("Подробнее ")]),_:2},1032,["to"])]),_:2},1024))),128))])):(r(),i("div",V,[a("div",A,[a("p",D,s(d(f).isLoading?"Подождите, загружаю...":"Записей не найдено..."),1)])])),a("div",$,[a("div",E,[a("p",null,[o("Всего записей: "),a("span",F,s(c.promos.length),1)])])])],64)}}};export{T as default};
