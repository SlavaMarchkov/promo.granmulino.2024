import{a as h,u as S,a7 as l}from"./app-CvDqXEOd.js";function y(){const n=o=>o.replace(/_([a-z])/g,c=>c[1].toUpperCase()),s=o=>o.replace(/([a-zA-Z])(?=[A-Z])/g,"$1_").toLowerCase(),i=(o,c)=>{const p={};for(const e in o)if(o.hasOwnProperty(e)){const r=o[e],t=c(e),u=typeof r=="object";p[t]=u?i(r,c):r}return p};return{toCamel:n,toSnake:s,makeConvertibleObject:i}}const{makeConvertibleObject:f,toSnake:d}=y();function C(){const n=h(),s=S();return{get:(e,r={})=>(n.showSpinner(),l.get(e,r).then(t=>t.data).catch(t=>(s.error(t),!1)).finally(()=>{n.hideSpinner()})),post:(e,r,t={})=>{n.disableButton();const u=f(r,d);return l.post(e,u,t).then(a=>a.data).catch(a=>(s.error(a,!0),!1)).finally(()=>{n.enableButton()})},update:(e,r,t={})=>{n.disableButton();const u=f(r,d);return l.put(e,u,t).then(a=>a.data).catch(a=>(s.error(a,!0),!1)).finally(()=>{n.enableButton()})},destroy:(e,r={})=>l.delete(e,r).then(t=>t.data).catch(t=>(s.error(t,!0),!1))}}export{C as u};
