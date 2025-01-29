import{d as g,B as w,af as ce,ag as ue,o as P,l as F,w as d,f as t,t as c,g as o,j as a,i as n,x as pe,T as K,r as se,ah as re,ai as de,z as we,aj as Ie,Z as ae,c as b,p as u,F as D,h as O,m as le,s as j,I as ne,q as _,y as Ne,ak as Ue}from"./app-LDVDDXIB.js";import{u as Ve}from"./useHttpService-H3Bhthf8.js";import{c as x,b as f,f as m,p as ie}from"./formatters-k0Na949k.js";import{_ as Te}from"./TheModal-aYJkSKq-.js";import{_ as Re}from"./TheCard-DltuzUPB.js";import{_ as h}from"./TwoColumnRow-BlIMmxAF.js";import{_ as q,u as Be}from"./InputRange-Cp8YmIPk.js";import{u as ke}from"./useArrayHandlers-JXOu8LuP.js";const Ce={class:"mb-0"},Ae={class:"mb-0 fw-bold text-primary"},Se=t("hr",null,null,-1),Me={__name:"DiscountProductCard",props:{index:{type:Number,default:1},product:{type:Object,required:!0},transportRatePerKilo:{type:Number,default:0}},emits:["removeProduct"],setup(T,{emit:R}){const i=T,B=R,k=()=>{B("removeProduct",i.index)},C=g(()=>i.product.netProfit>=20?"bg-success-light text-success":"bg-danger-light text-danger");w(()=>i.transportRatePerKilo,v=>{const I=y(v);i.product.profitPerUnit=i.product.promoPrice-i.product.productPrice-I-i.product.promoPrice*ce-i.product.promoPrice*ue,i.product.netProfit=Math.round(i.product.profitPerUnit/i.product.promoPrice*100),i.product.profitPerProductPlan=x(i.product.salesPlan)*i.product.profitPerUnit});const y=v=>v*(i.product.productWeight/1e3);return(v,I)=>(P(),F(Re,{"header-classes":["bg-secondary-subtle py-2 fw-bold text-black"],"with-footer":""},{header:d(()=>[t("h5",Ce,c(i.product.categoryName),1)]),body:d(()=>[t("h6",Ae,c(i.product.productName),1),Se,o(h,{title:"Скидка"},{default:d(()=>[a(c(i.product.discount)+" %",1)]),_:1}),o(h,{title:"Акционная цена"},{default:d(()=>[a(c(n(f)(i.product.promoPrice))+" руб.",1)]),_:1}),o(h,{title:"Продажи 'До'"},{default:d(()=>[a(c(n(m)(i.product.salesBefore))+" шт.",1)]),_:1}),o(h,{title:"План"},{default:d(()=>[a(c(n(m)(i.product.salesPlan))+" шт.",1)]),_:1}),o(h,{title:"Прирост"},{default:d(()=>[a(c(n(m)(i.product.surplusPlan))+" %",1)]),_:1}),o(h,{title:"Бюджет"},{default:d(()=>[a(c(n(m)(i.product.budgetPlan))+" руб.",1)]),_:1}),o(h,{title:"Прибыль на шт."},{default:d(()=>[a(c(n(f)(i.product.profitPerUnit))+" руб.",1)]),_:1}),o(h,{title:"Прибыль, план"},{default:d(()=>[a(c(n(f)(i.product.profitPerProductPlan))+" руб.",1)]),_:1}),o(h,{title:"Норматив ЧП"},{default:d(()=>[t("span",{class:pe(C.value)},"  "+c(n(m)(i.product.netProfit))+" %  ",3)]),_:1}),o(h,{title:"Выручка"},{default:d(()=>[a(c(n(m)(i.product.revenuePlan))+" руб.",1)]),_:1})]),footer:d(()=>[o(K,{class:"btn-danger w-100",onClick:k},{default:d(()=>[a("Удалить ")]),_:1})]),_:1}))}},Ee={class:"card"},$e={class:"card-header bg-success text-white"},We={class:"card-body mt-3"},De={class:"mb-1 d-flex justify-content-between align-items-center"},Oe=t("h4",{class:"mb-0"},"Итоговый бюджет на промо-акцию:",-1),je={class:"text-primary fw-bold mb-0"},qe={class:"d-flex justify-content-between align-items-center"},Fe=t("h4",{class:"mb-0"},"Плановая прибыль на промо-акцию:",-1),Ke={class:"text-primary fw-bold mb-0"},Le=t("hr",null,null,-1),Ge={class:"row"},He={class:"col-6"},ze={class:"mb-0 alert border-primary fade show",role:"alert"},Xe={class:"mb-0"},Ze={class:"fw-bold text-primary"},Je={class:"col-6"},Qe={class:"mb-0 alert border-primary fade show",role:"alert"},Ye={class:"mb-0"},et={class:"fw-bold text-primary"},tt=t("hr",null,null,-1),ot={class:"row mb-3"},st={class:"mb-2 d-flex justify-content-between align-items-center"},rt=t("h6",{class:"mb-0"},[t("span",{class:"fw-bold text-primary"},"Шаг 1."),a(" Расчёт стоимости доставки 1 кг продукции:")],-1),dt={class:"text-secondary fw-bold mb-0"},at={class:"col-md-6 col-sm-12"},lt={class:"fw-bold text-primary fs-5"},nt={class:"col-md-6 col-sm-12"},it={class:"fw-bold text-primary fs-5"},ct=t("hr",null,null,-1),ut={class:"d-flex justify-content-between align-items-center"},pt=t("h6",{class:"mb-0"},[t("span",{class:"fw-bold text-primary"},"Шаг 2."),a(" Ассортимент для промо-акции:")],-1),_t=t("hr",null,null,-1),mt={key:0,class:"row row-cols-xl-2 row-cols-lg-2 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3"},ft={class:"row g-3 mb-3"},gt={class:"col-md-6"},ht=t("option",{disabled:"",selected:"",value:""},"-- Выберите группу товара --",-1),Pt=["value"],vt={class:"col-md-6"},bt=t("option",{disabled:"",selected:"",value:""},"-- Выберите акционный продукт --",-1),xt=["value"],yt={class:"row g-3 mb-0"},wt={class:"col-12"},It={class:"fw-bold text-primary fs-5"},Nt={class:"mb-2 fs-6 text-primary text-end"},Ut={class:"row g-3 mb-3"},Vt={class:"col-md-6"},Tt={class:"input-group"},Rt=t("span",{class:"input-group-text"},"руб.",-1),Bt={class:"col-md-6"},kt={class:"input-group"},Ct=t("span",{class:"input-group-text"},"руб.",-1),At={class:"row g-3 mb-3"},St={class:"col-md-4"},Mt={class:"input-group"},Et=t("span",{class:"input-group-text"},"₽",-1),$t={class:"col-md-4"},Wt={class:"input-group"},Dt=t("span",{class:"input-group-text"},"₽",-1),Ot={class:"col-md-4"},jt={class:"input-group"},qt=t("span",{class:"input-group-text"},"₽",-1),Ft={class:"row g-3 mb-3"},Kt={class:"col-md-4"},Lt={class:"input-group"},Gt=t("span",{class:"input-group-text"},"₽",-1),Ht=t("div",{id:"office_expenses_help",class:"form-text"},"акционная цена * 7.5%",-1),zt={class:"col-md-4"},Xt={class:"input-group"},Zt=t("span",{class:"input-group-text"},"₽",-1),Jt=t("div",{id:"marketing_expenses_help",class:"form-text"},"акционная цена * 5%",-1),Qt={class:"col-md-4"},Yt={class:"input-group"},eo=t("span",{class:"input-group-text"},"₽",-1),to=t("hr",null,null,-1),oo={class:"row g-3 mb-3"},so={class:"col-md-4"},ro={class:"input-group"},ao=t("span",{class:"input-group-text"},"руб.",-1),lo=t("div",{id:"profit_per_unit_help",class:"form-text"},"рассчитывается автоматически",-1),no={class:"col-md-4"},io={class:"input-group"},co=t("span",{class:"input-group-text"},"руб.",-1),uo=t("div",{id:"compensation_help",class:"form-text"},"разница между прайсом и акц. ценой",-1),po={class:"col-md-4"},_o={class:"input-group"},mo=t("span",{class:"input-group-text"},"руб.",-1),fo=t("div",{id:"budget_plan_help",class:"form-text"},"компенсация * план продаж",-1),go={class:"row g-3 mb-3"},ho={class:"col-md-4"},Po={class:"input-group"},vo=t("span",{class:"input-group-text"},"шт.",-1),bo=t("div",{id:"sales_before_help",class:"form-text"},"если продаж не было, введите 0",-1),xo={class:"col-md-4"},yo={class:"input-group"},wo=t("span",{class:"input-group-text"},"шт.",-1),Io=t("div",{id:"sales_plan_help",class:"form-text"},"обязательно к заполнению",-1),No={class:"col-md-4"},Uo={class:"input-group"},Vo=t("span",{class:"input-group-text"},"%",-1),To=t("div",{id:"surplus_plan_help",class:"form-text"},"рассчитывается автоматически",-1),Ro=t("hr",null,null,-1),Bo={class:"row g-3"},ko={class:"col-md-4 offset-md-2"},Co={class:"input-group"},Ao=t("span",{class:"input-group-text"},"руб.",-1),So={class:"col-md-4"},Mo={class:"input-group"},Eo=t("span",{class:"input-group-text"},"%",-1),Lo={__name:"TheDiscount",props:{title:{type:String,required:!0,default:"Title is required"},customerId:{type:Number,default:0},customerName:{type:String,default:""},retailerName:{type:String,default:""}},emits:["addProductsToPromo"],setup(T,{emit:R}){const{get:i}=Ve(),{calcDifferencePercentage:B,calcBudget:k}=Be(),C=ke(),y=T,v=R,I=()=>({categoryId:"",productId:"",discount:0,promoPrice:0,salesBefore:0,salesPlan:0,surplusPlan:0,profitPerUnit:0,profitPerProductPlan:0,compensation:0,budgetPlan:0,netProfit:0,revenuePlan:0}),A=()=>({id:"",name:"",weight:0,price:0,priceNoVAT:0,initialPrice:0}),e=se({transportRate:re,orderWeight:de,categories:[],products:[],addedProducts:[],addedProductsIds:[],form:I(),product:A()}),N=se({addModalPopUp:!1}),V=we(!0),_e=()=>{e.categories.map(l=>{+l.id==+e.form.categoryId&&(e.products=l.products)}),e.products=e.products.filter(l=>!e.addedProductsIds.includes(l.id))},me=()=>{e.product=A();const l=e.categories.findIndex(s=>+s.id==+e.form.categoryId);e.product=e.categories[l].products.find(s=>s.id===+e.form.productId),e.form.discount=Ue,e.form.salesBefore=0,e.form.salesPlan=0,Q(e.form.discount),J(),W(),$(),Y(),ee()},fe=()=>{e.addedProducts.push({categoryId:e.form.categoryId,productId:e.form.productId,categoryName:he(),productName:Pe(),productWeight:e.product.weight,productPrice:e.product.initialPrice,salesBefore:e.form.salesBefore,salesPlan:e.form.salesPlan,surplusPlan:e.form.surplusPlan,budgetPlan:e.form.budgetPlan,compensation:e.form.compensation,profitPerUnit:e.form.profitPerUnit,discount:e.form.discount,promoPrice:e.form.promoPrice,profitPerProductPlan:e.form.profitPerProductPlan,netProfit:e.form.netProfit,revenuePlan:e.form.revenuePlan}),e.addedProductsIds.push(+e.form.productId),v("addProductsToPromo",e.addedProducts,L.value,G.value,S.value,M.value),e.products=[],N.addModalPopUp=!1},ge=l=>{e.addedProducts.splice(l,1),e.addedProductsIds.splice(l,1),v("addProductsToPromo",e.addedProducts,L.value,G.value,S.value,M.value)},he=()=>{const l=e.categories.findIndex(s=>+s.id==+e.form.categoryId);return e.categories[l].name},Pe=()=>{const l=e.categories.findIndex(r=>+r.id==+e.form.categoryId),s=e.categories[l].products.findIndex(r=>r.id===+e.form.productId);return e.categories[l].products[s].name},ve=g(()=>{let l=!0;const s=["salesBefore","surplusPlan","compensation","budgetPlan","profitPerUnit","netProfit"];for(let[r,p]of Object.entries(e.form))if(!s.includes(r)&&!p){l=!1;break}return l}),L=g(()=>e.addedProducts.reduce((l,s)=>Math.round(l+x(s.salesBefore)),0)),G=g(()=>e.addedProducts.reduce((l,s)=>Math.round(l+x(s.salesPlan)),0)),S=g(()=>e.addedProducts.reduce((l,s)=>Math.round(l+x(s.budgetPlan)),0)),M=g(()=>e.addedProducts.reduce((l,s)=>Math.round(l+x(s.profitPerProductPlan)),0)),E=g(()=>e.transportRate/Ie/e.orderWeight),H=g(()=>E.value*(e.product.weight/1e3)),z=g(()=>e.form.promoPrice*ce),X=g(()=>e.form.promoPrice*ue),Z=g(()=>e.form.promoPrice-e.product.initialPrice),be=g(()=>e.form.netProfit>=20?"bg-success-light text-success":"bg-danger-light text-danger");w(()=>y.customerId,async l=>{l!==0&&(e.categories=[],e.transportRate=re,e.orderWeight=de,e.addedProducts=[],e.addedProductsIds=[],await xe(l))}),w(()=>e.form.discount,l=>{Q(l),J(),W(),$(),Y(),ee()}),w(()=>e.form.salesBefore,()=>te()),w(()=>e.form.salesPlan,()=>{W(),te(),oe(),$()}),w(()=>e.form.compensation,()=>{oe()});const xe=async l=>{const{status:s,data:r}=await i(`${ae.CUSTOMER}/${l}${ae.PRODUCT}`,{params:{category:!0,product:!0,is_listed:!0}});s==="success"&&r.products.map(p=>{const U=e.categories.findIndex(ye=>ye.id===p.categoryId);U===-1?e.categories.push({id:p.categoryId,name:p.categoryName,products:[{id:p.productId,name:p.productName,weight:p.productWeight,price:p.customerPrice,priceNoVAT:p.customerPriceNoVAT,initialPrice:p.productInitialPrice}]}):(e.categories[U].products=[...e.categories[U].products,{id:p.productId,name:p.productName,weight:p.productWeight,price:p.customerPrice,priceNoVAT:p.customerPriceNoVAT,initialPrice:p.productInitialPrice}],e.categories[U].products=C.sortArrayByStringColumn(e.categories[U].products,"name"))})},J=()=>{e.form.profitPerUnit=Z.value-H.value-z.value-X.value},Q=l=>{const s=1-l/100;e.form.promoPrice=e.product.priceNoVAT*s},$=()=>{e.form.revenuePlan=Math.round(x(e.form.salesPlan)*e.form.promoPrice)},Y=()=>{e.form.netProfit=Math.round(e.form.profitPerUnit/e.form.promoPrice*100)},W=()=>{e.form.profitPerProductPlan=x(e.form.salesPlan)*e.form.profitPerUnit},ee=()=>{e.form.compensation=e.product.priceNoVAT-e.form.promoPrice};function te(){e.form.surplusPlan=B(e.form.salesBefore,e.form.salesPlan)}function oe(){e.form.budgetPlan=k(e.form.salesPlan,e.form.compensation)}return(l,s)=>(P(),b("div",null,[t("div",Ee,[t("div",$e,c(y.title),1),t("div",We,[t("div",De,[Oe,t("h4",je,c(n(m)(S.value))+" руб.",1)]),t("div",qe,[Fe,t("h4",Ke,c(n(m)(M.value))+" руб.",1)]),Le,t("div",Ge,[t("div",He,[t("div",ze,[t("h5",Xe,[a("Дистрибутор: "),t("span",Ze,c(y.customerName),1)])])]),t("div",Je,[t("div",Qe,[t("h5",Ye,[a("Сеть: "),t("span",et,c(y.retailerName),1)])])])]),tt,t("div",ot,[t("div",st,[rt,t("h5",dt,c(n(f)(E.value))+" руб/кг",1)]),t("div",at,[o(u,{for:"transport_rate"},{default:d(()=>[a("Стоимость доставки, вкл. НДС:  "),t("span",lt,c(n(m)(e.transportRate))+" руб. ",1)]),_:1}),o(q,{id:"transport_rate",modelValue:e.transportRate,"onUpdate:modelValue":s[0]||(s[0]=r=>e.transportRate=r),max:2e5,min:0,step:1e3},null,8,["modelValue"])]),t("div",nt,[o(u,{for:"order_weight"},{default:d(()=>[a("Вес заказа:  "),t("span",it,c(n(m)(e.orderWeight))+" кг ",1)]),_:1}),o(q,{id:"order_weight",modelValue:e.orderWeight,"onUpdate:modelValue":s[1]||(s[1]=r=>e.orderWeight=r),max:25e3,min:5e3,step:500},null,8,["modelValue"])])]),ct,t("div",ut,[pt,o(K,{onClick:s[2]||(s[2]=r=>{N.addModalPopUp=!0,e.form=I(),e.products=[],e.product=A()}),class:"btn-success",disabled:e.categories.length===0},{default:d(()=>[a("Добавить")]),_:1},8,["disabled"])]),_t,e.addedProducts.length>0?(P(),b("div",mt,[(P(!0),b(D,null,O(e.addedProducts,(r,p)=>(P(),F(Me,{key:r.id,index:p,product:r,"transport-rate-per-kilo":E.value,onRemoveProduct:ge},null,8,["index","product","transport-rate-per-kilo"]))),128))])):le("",!0)])]),N.addModalPopUp?(P(),F(Te,{key:0,modelValue:N.addModalPopUp,"onUpdate:modelValue":s[11]||(s[11]=r=>N.addModalPopUp=r),id:"addModalPopUp","custom-classes":["modal-lg"]},{title:d(()=>[a(" Добавление ассортимента для промо-акции ")]),body:d(()=>[t("div",ft,[t("div",gt,[o(u,{for:"category_id",required:""},{default:d(()=>[a("Группа товара")]),_:1}),j(t("select",{"onUpdate:modelValue":s[3]||(s[3]=r=>e.form.categoryId=r),onChange:_e,id:"category_id",class:"form-select"},[ht,(P(!0),b(D,null,O(e.categories,r=>(P(),b("option",{key:r.id,value:r.id},c(r.name),9,Pt))),128))],544),[[ne,e.form.categoryId]])]),t("div",vt,[o(u,{for:"product_id",required:""},{default:d(()=>[a("Ассортимент")]),_:1}),j(t("select",{"onUpdate:modelValue":s[4]||(s[4]=r=>e.form.productId=r),onChange:me,id:"product_id",class:"form-select"},[bt,(P(!0),b(D,null,O(e.products,r=>(P(),b("option",{key:r.id,value:r.id},c(r.name),9,xt))),128))],544),[[ne,e.form.productId]])])]),t("div",yt,[t("div",wt,[o(u,{for:"discount",class:"mb-0"},{default:d(()=>[a("Скидка:  "),t("span",It,c(e.form.discount)+" % ",1)]),_:1}),o(q,{id:"discount",modelValue:e.form.discount,"onUpdate:modelValue":s[5]||(s[5]=r=>e.form.discount=r),min:0,max:50,step:1,disabled:!e.form.productId},null,8,["modelValue","disabled"])])]),t("p",Nt,[t("span",{class:"border-bottom border-primary",style:{cursor:"pointer"},onClick:s[6]||(s[6]=r=>V.value=!V.value)},c(V.value?"Скрыть расчёт":"Показать расчёт"),1)]),j(t("div",null,[t("div",Ut,[t("div",Vt,[o(u,{for:"product_price"},{default:d(()=>[a("Цена прайса дистрибьютора")]),_:1}),t("div",Tt,[o(_,{id:"product_price","model-value":n(f)(e.product.price),class:"text-center bg-warning-light",tabindex:-1},null,8,["model-value"]),Rt])]),t("div",Bt,[o(u,{for:"product_price_no_vat"},{default:d(()=>[a("Цена прайса дистрибьютора без НДС")]),_:1}),t("div",kt,[o(_,{id:"product_price_no_vat","model-value":n(f)(e.product.priceNoVAT),class:"text-center bg-warning-light",tabindex:-1},null,8,["model-value"]),Ct])])]),t("div",At,[t("div",St,[o(u,{for:"customer_price"},{default:d(()=>[a("Акционная цена")]),_:1}),t("div",Mt,[o(_,{id:"customer_price","model-value":n(f)(e.form.promoPrice),class:"text-center bg-warning-light",readonly:"readonly",tabindex:-1},null,8,["model-value"]),Et])]),t("div",$t,[o(u,{for:"gross_profit"},{default:d(()=>[a("Валовая прибыль (без НДС)")]),_:1}),t("div",Wt,[o(_,{id:"gross_profit","model-value":n(f)(Z.value),class:"text-center bg-warning-light",readonly:"readonly",tabindex:-1},null,8,["model-value"]),Dt])]),t("div",Ot,[o(u,{for:"transport_rate_per_unit"},{default:d(()=>[a("Транспорт, руб/шт.")]),_:1}),t("div",jt,[o(_,{id:"transport_rate_per_unit","model-value":n(f)(H.value),class:"text-center bg-warning-light",readonly:"readonly",tabindex:-1},null,8,["model-value"]),qt])])]),t("div",Ft,[t("div",Kt,[o(u,{for:"office_expenses"},{default:d(()=>[a("Офис, руб/шт.")]),_:1}),t("div",Lt,[o(_,{id:"office_expenses","model-value":n(f)(z.value),class:"text-center bg-warning-light",readonly:"readonly","aria-describedby":"office_expenses_help",tabindex:-1},null,8,["model-value"]),Gt]),Ht]),t("div",zt,[o(u,{for:"marketing_expenses"},{default:d(()=>[a("Маркетинг, руб/шт.")]),_:1}),t("div",Xt,[o(_,{id:"marketing_expenses","model-value":n(f)(X.value),class:"text-center bg-warning-light",readonly:"readonly","aria-describedby":"marketing_expenses_help",tabindex:-1},null,8,["model-value"]),Zt]),Jt]),t("div",Qt,[o(u,{for:"profit_per_product"},{default:d(()=>[a("Прибыль на "+c(n(m)(e.form.salesPlan))+" шт.",1)]),_:1}),t("div",Yt,[o(_,{id:"profit_per_product","model-value":n(f)(e.form.profitPerProductPlan),class:"text-center bg-warning-light",readonly:"readonly",tabindex:-1},null,8,["model-value"]),eo])])])],512),[[Ne,V.value===!0]]),to,t("div",oo,[t("div",so,[o(u,{for:"profit_per_unit"},{default:d(()=>[a("Прибыль на 1 шт.")]),_:1}),t("div",ro,[o(_,{id:"profit_per_unit","model-value":n(f)(e.form.profitPerUnit),class:"text-center bg-warning-light",readonly:"readonly","aria-describedby":"profit_per_unit_help",tabindex:-1},null,8,["model-value"]),ao]),lo]),t("div",no,[o(u,{for:"compensation"},{default:d(()=>[a("Компенсация на 1 шт.")]),_:1}),t("div",io,[o(_,{id:"compensation","model-value":n(f)(e.form.compensation),class:"text-center bg-warning-light",readonly:"readonly","aria-describedby":"compensation_help",tabindex:-1},null,8,["model-value"]),co]),uo]),t("div",po,[o(u,{for:"budget_plan"},{default:d(()=>[a("Бюджет")]),_:1}),t("div",_o,[o(_,{id:"budget_plan","model-value":n(m)(e.form.budgetPlan),class:"text-center fw-bold",disabled:"disabled","aria-describedby":"budget_plan_help"},null,8,["model-value"]),mo]),fo])]),t("div",go,[t("div",ho,[o(u,{for:"sales_before",required:""},{default:d(()=>[a('Продажи "До акции"')]),_:1}),t("div",Po,[o(_,{id:"sales_before",modelValue:e.form.salesBefore,"onUpdate:modelValue":s[7]||(s[7]=r=>e.form.salesBefore=r),class:"text-center","aria-describedby":"sales_before_help",onBlur:s[8]||(s[8]=r=>n(ie)(r.target.value,"sales_before")),disabled:!e.form.productId},null,8,["modelValue","disabled"]),vo]),bo]),t("div",xo,[o(u,{for:"sales_plan",required:""},{default:d(()=>[a('План продаж "Во время"')]),_:1}),t("div",yo,[o(_,{id:"sales_plan",modelValue:e.form.salesPlan,"onUpdate:modelValue":s[9]||(s[9]=r=>e.form.salesPlan=r),class:"text-center","aria-describedby":"sales_plan_help",onBlur:s[10]||(s[10]=r=>n(ie)(r.target.value,"sales_plan")),disabled:!e.form.productId},null,8,["modelValue","disabled"]),wo]),Io]),t("div",No,[o(u,{for:"surplus_plan"},{default:d(()=>[a("План прироста")]),_:1}),t("div",Uo,[o(_,{id:"surplus_plan","model-value":n(m)(e.form.surplusPlan),class:"text-center fw-bold",disabled:"disabled","aria-describedby":"surplus_plan_help"},null,8,["model-value"]),Vo]),To])]),Ro,t("div",Bo,[t("div",ko,[o(u,{for:"revenue_plan"},{default:d(()=>[a("Выручка")]),_:1}),t("div",Co,[o(_,{id:"revenue_plan","model-value":n(m)(e.form.revenuePlan),class:"text-center bg-warning-light",readonly:"readonly",tabindex:-1},null,8,["model-value"]),Ao])]),t("div",So,[o(u,{for:"net_profit_standard"},{default:d(()=>[a("Норматив чистой прибыли")]),_:1}),t("div",Mo,[o(_,{id:"net_profit_standard","model-value":isNaN(e.form.netProfit)?0:n(m)(e.form.netProfit),class:pe(["text-center fw-bold",be.value]),readonly:"readonly",tabindex:-1},null,8,["model-value","class"]),Eo])])])]),footer:d(()=>[o(K,{onClick:fe,class:"btn-success w-25",disabled:!ve.value},{default:d(()=>[a("Добавить")]),_:1},8,["disabled"])]),_:1},8,["modelValue"])):le("",!0)]))}};export{Lo as default};
