import{a as v,y as w,e as g,A as k,G as x,d as f,c as n,f as t,i as R,F as u,t as o,l as I,g as N,w as S,z as V,B,k as D,o as s,j as C,n as L}from"./app-CvDqXEOd.js";import{u as F}from"./useHttpService-Cv4QBHm9.js";const T={class:"row"},$={class:"col-12"},j={class:"card"},A={class:"card-body"},E=t("h4",{class:"my-4"},"Загрузка...",-1),G=t("table",{class:"table table-bordered mb-4 align-middle text-wrap",style:{width:"100%"}},[t("tbody",null,[t("tr",null,[t("th",{style:{width:"20%"}},"ID"),t("td")]),t("tr",null,[t("th",null,"Регион"),t("td")]),t("tr",null,[t("th",null,"Код"),t("td")])])],-1),M=t("button",{class:"btn btn-outline-secondary",disabled:"",role:"button"},"Пред. ",-1),O=t("button",{class:"btn btn-outline-secondary mx-2",disabled:"",role:"button"},"След. ",-1),z={key:0},H={class:"my-4"},P={class:"table table-bordered mb-4 align-middle text-wrap",style:{width:"100%"}},U=t("th",{style:{width:"20%"}},"ID",-1),q=t("th",null,"Регион",-1),J=t("th",null,"Код",-1),K=["disabled"],Q=["disabled"],W=t("hr",null,null,-1),tt={__name:"View",setup(X){const a=V(),d=B(),r=v(),{get:_}=F(),b=+a.params.id,e=w({});g(async()=>{await c(b)});const c=async i=>{const l=await _(`${k.REGION}/${i}`);l.status==="success"&&(e.value=l.data)};x(()=>a.params.id,()=>{c(a.params.id)});const h=f(()=>Object.keys(e.value).length!==0),m=()=>{d.push({name:"Region.View",params:{id:e.value.prev}})},p=()=>{d.push({name:"Region.View",params:{id:e.value.next}})};return(i,l)=>{const y=D("RouterLink");return s(),n("div",T,[t("div",$,[t("div",j,[t("div",A,[R(r).isLoading?(s(),n(u,{key:0},[E,G,M,O],64)):(s(),n(u,{key:1},[h.value?(s(),n("div",z,[t("h4",H,o(e.value.name),1),t("table",P,[t("tbody",null,[t("tr",null,[U,t("td",null,o(e.value.id),1)]),t("tr",null,[q,t("td",null,o(e.value.name),1)]),t("tr",null,[J,t("td",null,o(e.value.code),1)])])]),t("button",{onClick:m,class:"btn btn-outline-secondary",disabled:e.value.prev===null,role:"button"},"Пред. ",8,K),t("button",{onClick:p,class:"btn btn-outline-secondary mx-2",disabled:e.value.next===null,role:"button"},"След. ",8,Q)])):(s(),I(L,{key:1,class:"mt-3"}))],64)),W,N(y,{to:{name:"Region.Index"},class:"btn btn-secondary my-2",role:"button"},{default:S(()=>[C("Обратно на Регионы ")]),_:1})])])])])}}};export{tt as default};
