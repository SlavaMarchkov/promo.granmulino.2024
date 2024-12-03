import{u as ne,a as ae,b as le,d as v,r as D,e as ie,A as w,c as i,f as e,g as d,w as o,F as E,h as I,t as c,i as p,j as l,k as de,o as a,l as L,m as re,n as ce,p as U,q as $,T as ue,x as _e,R as me,C as N,E as C,D as pe}from"./app-CvDqXEOd.js";import{u as he}from"./useHttpService-Cv4QBHm9.js";import{u as ge}from"./useArrayHandlers-Dmi2z74m.js";import{_ as be,a as M}from"./TheFilter-VzPJfpVU.js";import{_ as A}from"./Modal-BjKEkhVV.js";import{_ as fe,a as k}from"./TdButton-DoOWIy6T.js";const ye={class:"row mb-2"},ve={class:"col-12"},we={class:"col-md-4 mb-2"},Ee={class:"col-md-4 mb-2"},Se={class:"row mb-4"},Re={class:"col-12"},Ie={class:"card"},ke={class:"card-body pb-0"},Ve={key:0,class:"table-responsive"},xe={class:"table table-bordered my-4 text-center align-middle text-nowrap",style:{width:"100%"}},Be={scope:"row"},De={class:"text-start"},Le={class:"text-start"},Ue={key:1,class:"mt-3 text-center lead"},$e={class:"fw-bold"},Ne={key:0},Ce={key:1},Me={class:"row g-3"},Ae={class:"col-12"},He={class:"col-12"},Te={key:0},Fe={key:1},Oe={key:0},Pe={class:"bd-callout bd-callout-info"},Ge={class:"table table-bordered text-center align-middle text-wrap",style:{width:"100%"}},Ke=e("thead",{class:"table-light"},[e("tr",null,[e("th",null,"ID"),e("th",{class:"text-start"},"Название города")])],-1),qe={class:"text-start"},je={key:1,class:"bd-callout bd-callout-warning"},ze=e("h5",null,"Регион пустой",-1),Je=e("hr",null,null,-1),Qe=e("p",null,[l("Наполните регион городами во вкладке "),e("b",null,"Справочники | Города"),l(".")],-1),We=[ze,Je,Qe],Xe=e("span",null,null,-1),lt={__name:"Index",setup(Ye){const g=ne(),S=ae(),H=le(),u=ge(),{get:T,post:F,update:O,destroy:P}=he(),G=H.getUser.role,V=v(()=>G===me.SUPER_ADMIN),K=v(()=>V?N.concat(C,pe):N.concat(C)),b=()=>({code:"",name:""}),t=D({regions:[],region:b(),isEditing:!1}),m=D({code:"",name:""});let _=null,h=null;function f(){t.isEditing=!1,t.region=b()}ie(async()=>{await y(),_=new bootstrap.Modal(document.getElementById("modalPopUp")),_._element.addEventListener("hide.bs.modal",f)});const y=async()=>{const{data:n}=await T(w.REGION);t.regions=n.regions},x=n=>t.regions.find(r=>r.id===n),q=()=>{g.clear(),t.isEditing=!1,t.region=b(),_.show()},j=n=>{g.clear(),t.isEditing=!0,t.region=x(n),_.show()},z=n=>{h=new bootstrap.Modal(document.getElementById("viewModalPopUp")),t.region=x(n),h.show(),h._element.addEventListener("hide.bs.modal",f)},J=()=>{_.hide(),_._element.removeEventListener("hide.bs.modal",f)},Q=()=>{h.hide(),h._element.removeEventListener("hide.bs.modal",f)},W=()=>{u.resetSearchKeys(m),u.resetSortKeys()},X=async()=>{if(t.isEditing){const n=await O(`${w.REGION}/${t.region.id}`,t.region);n&&n.status==="success"&&(g.clear(),_.hide(),await y())}else{const n=await F(w.REGION,t.region);n&&n.status==="success"&&(g.clear(),t.region=b(),_.hide(),u.resetSearchKeys(m),u.resetSortKeys("id",!1),await y())}},Y=async n=>{if(confirm("Точно удалить регион? Уверены?")){const r=await P(`${w.REGION}/${n}`);r&&r.status==="success"&&await y()}},Z=v(()=>u.sortArray(t.regions)),R=v(()=>u.filterArray(Z.value,m));return(n,r)=>{const ee=de("RouterLink");return a(),i(E,null,[e("div",{class:"row mb-4"},[e("div",{class:"col-12"},[e("button",{class:"btn btn-primary",type:"button",onClick:q}," Новый регион ")])]),e("div",ye,[e("div",ve,[d(be,{onResetFilter:W},{default:o(()=>[e("div",we,[d(M,{modelValue:m.name,"onUpdate:modelValue":r[0]||(r[0]=s=>m.name=s),placeholder:"Поиск по названию региона"},{default:o(()=>[l("Название ")]),_:1},8,["modelValue"])]),e("div",Ee,[d(M,{modelValue:m.code,"onUpdate:modelValue":r[1]||(r[1]=s=>m.code=s),placeholder:"Поиск по коду региона"},{default:o(()=>[l("Код ")]),_:1},8,["modelValue"])])]),_:1})])]),e("div",Se,[e("div",Re,[e("div",Ie,[e("div",ke,[R.value.length>0?(a(),i("div",Ve,[e("table",xe,[e("thead",null,[e("tr",null,[(a(!0),i(E,null,I(K.value,({column:s,label:te,sortable:se,is_num:B,width:oe})=>(a(),L(fe,{key:s,column:s,"is-numeric":B,"sort-by-asc":p(u).sortBy.asc,"sort-by-column":p(u).sortBy.column===s,sortable:se,width:oe,onSetSort:Ze=>p(u).setSort(s,B)},{default:o(()=>[l(c(te),1)]),_:2},1032,["column","is-numeric","sort-by-asc","sort-by-column","sortable","width","onSetSort"]))),128))])]),e("tbody",null,[(a(!0),i(E,null,I(R.value,s=>(a(),i("tr",{key:s.id},[e("th",Be,c(s.id),1),e("td",De,[d(ee,{to:{name:"Region.View",params:{id:s.id}}},{default:o(()=>[l(c(s.name),1)]),_:2},1032,["to"])]),e("td",Le,c(s.code),1),e("td",null,c(s.citiesCount),1),d(k,{id:s.id,intent:"view",onRunButtonHandler:z},{default:o(()=>[l("View ")]),_:2},1032,["id"]),d(k,{id:s.id,intent:"edit",onRunButtonHandler:j},{default:o(()=>[l("Edit ")]),_:2},1032,["id"]),V.value?(a(),L(k,{key:0,id:s.id,intent:"delete",onRunButtonHandler:Y},{default:o(()=>[l("Delete ")]),_:2},1032,["id"])):re("",!0)]))),128))])])])):(a(),i("p",Ue,c(p(S).isLoading?"Подождите, загружаю...":"Записей не найдено..."),1)),e("p",null,[l("Всего записей: "),e("span",$e,c(R.value.length),1)])])])])]),d(A,{id:"modalPopUp","close-func":J,"custom-classes":[""]},{title:o(()=>[t.isEditing?(a(),i("span",Ne,[l("Редактирование региона "),e("b",null,c(t.region.name),1)])):(a(),i("span",Ce,"Добавление региона"))]),body:o(()=>[d(ce),e("div",Me,[e("div",Ae,[d(U,{for:"name",required:""},{default:o(()=>[l("Наименование региона")]),_:1}),d($,{id:"name",modelValue:t.region.name,"onUpdate:modelValue":r[2]||(r[2]=s=>t.region.name=s),placeholder:"Например: Уральский федеральный округ",type:"text"},null,8,["modelValue"])]),e("div",He,[d(U,{for:"code",required:""},{default:o(()=>[l("Код региона")]),_:1}),d($,{id:"code",modelValue:t.region.code,"onUpdate:modelValue":r[3]||(r[3]=s=>t.region.code=s),placeholder:"Например: УФО",type:"text"},null,8,["modelValue"])])])]),footer:o(()=>[d(ue,{class:_e([t.isEditing?"btn-warning":"btn-primary","w-25"]),disabled:p(S).isButtonDisabled,loading:p(S).isButtonDisabled,type:"button",onClick:X},{default:o(()=>[t.isEditing?(a(),i("span",Te,"Сохранить")):(a(),i("span",Fe,"Создать"))]),_:1},8,["class","disabled","loading"])]),_:1}),d(A,{id:"viewModalPopUp","close-func":Q,"custom-classes":["modal-dialog-scrollable"]},{title:o(()=>[l(" Просмотр региона "),e("b",null,c(t.region.name),1)]),body:o(()=>[t.region.citiesCount>0?(a(),i("div",Oe,[e("div",Pe,[e("p",null,[l("Всего городов в регионе: "),e("strong",null,c(t.region.citiesCount),1)])]),e("table",Ge,[Ke,e("tbody",null,[(a(!0),i(E,null,I(t.region.cities,s=>(a(),i("tr",{key:s.id},[e("td",null,c(s.id),1),e("td",qe,c(s.name),1)]))),128))])])])):(a(),i("div",je,We))]),footer:o(()=>[Xe]),_:1})],64)}}};export{lt as default};
