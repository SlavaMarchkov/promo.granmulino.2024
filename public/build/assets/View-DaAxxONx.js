import{a as v,y as w,e as k,A as x,G as f,d as g,c as n,f as t,i as C,F as r,t as o,l as I,g as S,w as V,z as B,B as D,k as N,o as s,j as R,n as L}from"./app-CvDqXEOd.js";import{u as T}from"./useHttpService-Cv4QBHm9.js";const F={class:"row"},$={class:"col-12"},j={class:"card"},A={class:"card-body"},M=t("h4",{class:"my-4"},"Загрузка...",-1),z=t("table",{class:"table table-bordered mb-4 align-middle text-wrap",style:{width:"100%"}},[t("tbody",null,[t("tr",null,[t("th",{style:{width:"20%"}},"ID"),t("td")]),t("tr",null,[t("th",null,"Регион"),t("td")]),t("tr",null,[t("th",null,"Код"),t("td")])])],-1),E=t("button",{class:"btn btn-outline-secondary",disabled:"",role:"button"},"Пред. ",-1),G=t("button",{class:"btn btn-outline-secondary mx-2",disabled:"",role:"button"},"След. ",-1),H={key:0},O={class:"my-4"},P={class:"table table-bordered mb-4 align-middle text-wrap",style:{width:"100%"}},U=t("th",{style:{width:"20%"}},"ID",-1),Y=t("th",null,"Город",-1),q=t("th",null,"Регион",-1),J=["disabled"],K=["disabled"],Q=t("hr",null,null,-1),tt={__name:"View",setup(W){const a=B(),d=D(),u=v(),{get:_}=T(),b=+a.params.id,e=w({});k(async()=>{await i(b)});const i=async c=>{const l=await _(`${x.CITY}/${c}`);l.status==="success"&&(e.value=l.data)};f(()=>a.params.id,()=>{i(a.params.id)});const h=g(()=>Object.keys(e.value).length!==0),m=()=>{d.push({name:"City.View",params:{id:e.value.prev}})},y=()=>{d.push({name:"City.View",params:{id:e.value.next}})};return(c,l)=>{const p=N("RouterLink");return s(),n("div",F,[t("div",$,[t("div",j,[t("div",A,[C(u).isLoading?(s(),n(r,{key:0},[M,z,E,G],64)):(s(),n(r,{key:1},[h.value?(s(),n("div",H,[t("h4",O,o(e.value.name),1),t("table",P,[t("tbody",null,[t("tr",null,[U,t("td",null,o(e.value.id),1)]),t("tr",null,[Y,t("td",null,o(e.value.name),1)]),t("tr",null,[q,t("td",null,o(e.value.region),1)])])]),t("button",{onClick:m,class:"btn btn-outline-secondary",disabled:e.value.prev===null,role:"button"},"Пред. ",8,J),t("button",{onClick:y,class:"btn btn-outline-secondary mx-2",disabled:e.value.next===null,role:"button"},"След. ",8,K)])):(s(),I(L,{key:1,class:"mt-3"}))],64)),Q,S(p,{to:{name:"City.Index"},class:"btn btn-secondary my-2",role:"button"},{default:V(()=>[R("Обратно на Города ")]),_:1})])])])])}}};export{tt as default};
