import{a as w,y as f,e as k,A as x,G as g,d as C,c as o,f as t,i as S,F as c,t as s,g as u,l as I,w as N,N as V,z as R,B,k as D,o as n,j as L,n as T}from"./app-CvDqXEOd.js";import{u as $}from"./useHttpService-Cv4QBHm9.js";import{_ as A}from"./TheBadge-BBHb-MvK.js";const F={class:"row"},M={class:"col-12"},j={class:"card"},E={class:"card-body"},O=V('<h4 class="my-4">Загрузка...</h4><table class="table table-bordered mb-4 align-middle text-wrap" style="width:100%;"><tbody><tr><th style="width:20%;">ID</th><td></td></tr><tr><th>Название</th><td></td></tr><tr><th>Регион</th><td></td></tr><tr><th>Город</th><td></td></tr><tr><th>Менеджер</th><td></td></tr><tr><th>Активен?</th><td></td></tr><tr><th>Описание</th><td></td></tr></tbody></table>',2),U=t("button",{class:"btn btn-outline-secondary",disabled:"",role:"button"},"Пред. ",-1),z=t("button",{class:"btn btn-outline-secondary mx-2",disabled:"",role:"button"},"След. ",-1),G={key:0},H={class:"my-4"},P={class:"table table-bordered mb-4 align-middle text-wrap",style:{width:"100%"}},q=t("th",{style:{width:"20%"}},"ID",-1),J=t("th",null,"Название",-1),K=t("th",null,"Регион",-1),Q=t("th",null,"Город",-1),W=t("th",null,"Менеджер",-1),X=t("th",null,"Активен?",-1),Y=t("th",null,"Описание",-1),Z=["disabled"],tt=["disabled"],et=t("hr",null,null,-1),lt={__name:"View",setup(st){const a=R(),d=B(),_=w(),{get:h}=$(),m=+a.params.id,e=f({});k(async()=>{await i(m)});const i=async r=>{const l=await h(`${x.CUSTOMER}/${r}`);l.status==="success"&&(e.value=l.data)};g(()=>a.params.id,()=>{i(a.params.id)});const b=C(()=>Object.keys(e.value).length!==0),v=()=>{d.push({name:"Customer.View",params:{id:e.value.prev}})},p=()=>{d.push({name:"Customer.View",params:{id:e.value.next}})};return(r,l)=>{const y=D("RouterLink");return n(),o("div",F,[t("div",M,[t("div",j,[t("div",E,[S(_).isLoading?(n(),o(c,{key:0},[O,U,z],64)):(n(),o(c,{key:1},[b.value?(n(),o("div",G,[t("h4",H,s(e.value.name),1),t("table",P,[t("tbody",null,[t("tr",null,[q,t("td",null,s(e.value.id),1)]),t("tr",null,[J,t("td",null,s(e.value.name),1)]),t("tr",null,[K,t("td",null,s(e.value.region),1)]),t("tr",null,[Q,t("td",null,s(e.value.city),1)]),t("tr",null,[W,t("td",null,s(e.value.user),1)]),t("tr",null,[X,t("td",null,[u(A,{"is-active":e.value.isActive},null,8,["is-active"])])]),t("tr",null,[Y,t("td",null,s(e.value.description),1)])])]),t("button",{onClick:v,class:"btn btn-outline-secondary",disabled:e.value.prev===null,role:"button"},"Пред. ",8,Z),t("button",{onClick:p,class:"btn btn-outline-secondary mx-2",disabled:e.value.next===null,role:"button"},"След. ",8,tt)])):(n(),I(T,{key:1,class:"mt-3"}))],64)),et,u(y,{to:{name:"Customer.Index"},class:"btn btn-secondary my-2",role:"button"},{default:N(()=>[L("Обратно на Контрагенты ")]),_:1})])])])])}}};export{lt as default};
