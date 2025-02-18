/*1453365082,,JIT Construction: v2138186,en_US*/

/**
 * Copyright Facebook Inc.
 *
 * Licensed under the Apache License, Version 2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 */
try {window.FB || (function(window, fb_fif_window) {  var apply = Function.prototype.apply;  function bindContext(fn, thisArg) {    return function _sdkBound() {      return apply.call(fn, thisArg, arguments);    };  }  var global = {    __type: 'JS_SDK_SANDBOX',    window: window,    document: window.document  };  var sandboxWhitelist = [    'setTimeout',    'setInterval',    'clearTimeout',    'clearInterval'  ];  for (var i = 0; i < sandboxWhitelist.length; i++) {    global[sandboxWhitelist[i]] = bindContext(      window[sandboxWhitelist[i]],      window    );  }  (function() {    var self = window;    var __DEV__ = 1;    function emptyFunction() {};    var __transform_includes = {"typechecks":true};    var __annotator, __bodyWrapper;    var __w, __t;    var undefined;    with (this) {      /** Path: html/js/downstream/polyfill/GenericFunctionVisitor.js */
/**
 * @generated SignedSource<<c08ae7cb38fd761137a759ab955d052d>>
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !! This file is a check-in of a static_upstream project!      !!
 * !!                                                            !!
 * !! You should not modify this file directly. Instead:         !!
 * !! 1) Use `fjs use-upstream` to temporarily replace this with !!
 * !!    the latest version from upstream.                       !!
 * !! 2) Make your changes, test them, etc.                      !!
 * !! 3) Use `fjs push-upstream` to copy your changes back to    !!
 * !!    static_upstream.                                        !!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @provides GenericFunctionVisitor
 * @polyfill
 *
 * This file contains the functions used for the generic JS function
 * transform. Please add your functionality to these functions if you
 * want to wrap or annotate functions.
 *
 * Please see the DEX https://fburl.com/80903169 for more information.
 */


(function(){
var funcCalls={};

var createMeta=function(type,signature){
if(!type && !signature){
return null;}


var meta={};
if(typeof type !== 'undefined'){
meta.type = type;}


if(typeof signature !== 'undefined'){
meta.signature = signature;}


return meta;};


var getMeta=function(name,params){
return createMeta(
name && /^[A-Z]/.test(name)?name:undefined,
params && (params.params && params.params.length || params.returns)?
'function(' + (
params.params?params.params.map(function(param){
return (/\?/.test(param)?
'?' + param.replace('?',''):
param);}).
join(','):'') +
')' + (
params.returns?':' + params.returns:''):
undefined);};



var noopAnnotator=function(fn,funcMeta,params){
return fn;};


var genericAnnotator=function(fn,funcMeta,params){
if('sourcemeta' in __transform_includes){
fn.__SMmeta = funcMeta;}


if('typechecks' in __transform_includes){
var meta=getMeta(funcMeta?funcMeta.name:undefined,params);
if(meta){
__w(fn,meta);}}


return fn;};


var noopBodyWrapper=function(scope,args,fn){
return fn.apply(scope,args);};


var typecheckBodyWrapper=function(scope,args,fn,params){
if(params && params.params){
__t.apply(scope,params.params);}


var result=fn.apply(scope,args);

if(params && params.returns){
__t([result,params.returns]);}


return result;};


var codeUsageBodyWrapper=function(scope,args,fn,params,funcMeta){
if(funcMeta){
if(!funcMeta.callId){


funcMeta.callId = funcMeta.module + ':' + (
funcMeta.line || 0) + ':' + (
funcMeta.column || 0);}

var key=funcMeta.callId;
funcCalls[key] = (funcCalls[key] || 0) + 1;}

return fn.apply(scope,args);};



if(typeof __transform_includes === 'undefined'){
__annotator = noopAnnotator;
__bodyWrapper = noopBodyWrapper;}else
{
__annotator = genericAnnotator;

if('codeusage' in __transform_includes){
__annotator = noopAnnotator;
__bodyWrapper = codeUsageBodyWrapper;
__bodyWrapper.getCodeUsage = function(){return funcCalls;};
__bodyWrapper.clearCodeUsage = function(){funcCalls = {};};}else
if('typechecks' in __transform_includes){
__bodyWrapper = typecheckBodyWrapper;}else
{
__bodyWrapper = noopBodyWrapper;}}})();
/** Path: html/js/downstream/polyfill/TypeChecker.js */
/**
 * @generated SignedSource<<c5fa97be145c81908e39158b1e7dc11c>>
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !! This file is a check-in of a static_upstream project!      !!
 * !!                                                            !!
 * !! You should not modify this file directly. Instead:         !!
 * !! 1) Use `fjs use-upstream` to temporarily replace this with !!
 * !!    the latest version from upstream.                       !!
 * !! 2) Make your changes, test them, etc.                      !!
 * !! 3) Use `fjs push-upstream` to copy your changes back to    !!
 * !!    static_upstream.                                        !!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * This is a very basic typechecker that does primitives as well as boxed
 * versions of the primitives.
 *
 * @provides TypeChecker
 * @nostacktrace
 * @polyfill
 */


(function(){
var handler;
var currentType=[];
var toStringFunc=Object.prototype.toString;
var paused=false;
var disabled=false;


var nextType;
var nextValue;




var typeInterfaceMap={
'HTMLElement':{'DOMEventTarget':true,'DOMNode':true},
'DOMElement':{'DOMEventTarget':true,'DOMNode':true},
'DOMDocument':{'DOMEventTarget':true,'DOMNode':true},
'DocumentFragment':{
'DOMElement':true,
'DOMEventTarget':true,
'DOMNode':true},

'DOMWindow':{'DOMEventTarget':true},
'DOMTextNode':{'DOMNode':true},
'Comment':{'DOMNode':true},
'file':{'blob':true},
'worker':{'DOMEventTarget':true},

'Set':{'set':true},
'Map':{'map':true},
'FbtResult':{'Fbt':true},
'string':{'Fbt':true},
'array':{'Fbt':true}};







function stringType(value){
return toStringFunc.call(value).slice(8,-1);}


function getTagName(string){
switch(string){
case 'A':
return 'Anchor';
case 'IMG':
return 'Image';
case 'TEXTAREA':
return 'TextArea';}

return string.charAt(0).toUpperCase() + string.substring(1).toLowerCase();}





function isDOMNode(type,value,nodeType){
if(type === 'function'){


if(typeof value.call !== 'undefined'){
return false;}}else

if(type !== 'object'){
return false;}


return typeof value.nodeName === 'string' && value.nodeType === nodeType;}





function getObjectType(type,value,node,checkNextNode){
nextValue = null;


var toStringType=stringType(value);
if(value === null){
type = 'null';}else
if(toStringType === 'Function'){
if(node === '$Class'){

type = '$Class';
if(checkNextNode && value.__TCmeta && value.__TCmeta.type){
nextType = value.__TCmeta.type;}}else

{
if(value.__TCmeta){

type = node === 'function'?'function':value.__TCmeta.signature;}else
{

type = node.indexOf('function') === 0?node:'function';}}}else


if(type === 'object' || type === 'function'){
var constructor=value.constructor;
if(constructor && constructor.__TCmeta){


if(node === 'object'){
type = 'object';}else
{
type = constructor.__TCmeta.type;
while(constructor && constructor.__TCmeta) {
if(constructor.__TCmeta.type == node){
type = node;
break;}

constructor = constructor.__TCmeta.superClass;}}}else


if(typeof value.nodeType === 'number' &&
typeof value.nodeName === 'string'){


switch(value.nodeType){
case 1:
if(node === 'HTMLElement'){

type = 'HTMLElement';}else
{
type = 'HTML' + getTagName(value.nodeName) + 'Element';
typeInterfaceMap[type] = typeInterfaceMap['HTMLElement'];}

break;
case 3:type = 'DOMTextNode';break;
case 8:type = 'Comment';break;
case 9:type = 'DOMDocument';break;
case 11:type = 'DocumentFragment';break;}}else

if(value == value.window && value == value.self){
type = 'DOMWindow';}else
if(toStringType == 'XMLHttpRequest' ||
'setRequestHeader' in value){

type = 'XMLHttpRequest';}else
{

switch(toStringType){
case 'Error':

type = node === 'Error'?
'Error':
value.name;
break;
case 'Array':
if(checkNextNode && value.length){
nextValue = value[0];}

type = toStringType.toLowerCase();
break;
case 'Object':
if(node === 'Set' && value['@@__IMMUTABLE_SET__@@'] ||
node === 'Map' && value['@@__IMMUTABLE_MAP__@@']){
type = node;}else
{
if(checkNextNode){
for(var key in value) {
if(value.hasOwnProperty(key)){
nextValue = value[key];
break;}}}



type = toStringType.toLowerCase();}

break;
case 'RegExp':
case 'Date':
case 'Blob':
case 'File':
case 'FileList':
case 'Worker':
case 'Map':
case 'Set':

case 'Uint8Array':
case 'Int8Array':
case 'Uint16Array':
case 'Int16Array':
case 'Uint32Array':
case 'Int32Array':
case 'Float32Array':
case 'Float64Array':
type = toStringType.toLowerCase();
break;}}}



return type;}











function equals(value,node){



var nullable=node.charAt(0) === '?';


if(value == null){
currentType.push(typeof value === 'undefined'?'undefined':'null');
return nullable;}else
if(nullable){
node = node.substring(1);}


var type=typeof value;

if(node === 'Fbt' && type === 'string'){
return true;}


switch(type){
case 'boolean':
case 'number':
case 'string':


currentType.push(type);
return node === type;}





var simpleMatch=false;
switch(node){
case 'function':

simpleMatch = type === 'function' && typeof value.call === 'function';
break;
case 'object':

simpleMatch = type === 'object' && stringType(value) === 'Object';
break;
case 'array':
simpleMatch = type === 'object' && stringType(value) === 'Array';
break;
case 'promise':
simpleMatch = type === 'object' && typeof value.then === 'function';
break;
case 'HTMLElement':
simpleMatch = isDOMNode(type,value,1);
break;
case 'DOMTextNode':
simpleMatch = isDOMNode(type,value,3);
break;
case 'Iterator':
simpleMatch = type === 'object' && typeof value.next === 'function';
break;
case 'IteratorResult':
simpleMatch = type === 'object' && typeof value.done === 'boolean';
break;
case 'OrderedMap':

case 'ImmOrderedMap':
simpleMatch = type === 'object' &&
value['@@__IMMUTABLE_ORDERED__@@'] &&
value['@@__IMMUTABLE_MAP__@@'];
break;
case 'OrderedSet':

case 'ImmOrderedSet':
simpleMatch = type === 'object' &&
value['@@__IMMUTABLE_ORDERED__@@'] &&
value['@@__IMMUTABLE_SET__@@'];
break;
case 'ImmMap':
simpleMatch = type === 'object' && value['@@__IMMUTABLE_MAP__@@'];
break;
case 'ImmSet':
simpleMatch = type === 'object' && value['@@__IMMUTABLE_SET__@@'];
break;
case 'List':
simpleMatch = type === 'object' && value['@@__IMMUTABLE_LIST__@@'];
break;}


if(simpleMatch){
currentType.push(node);
return true;}



var indexOfFirstAngle=node.indexOf('<');
var nextNode;

if(indexOfFirstAngle !== -1 && node.indexOf('function') !== 0){
nextNode = node.substring(indexOfFirstAngle + 1,node.lastIndexOf('>'));
node = node.substring(0,indexOfFirstAngle);}



type = getObjectType(type,value,node,!!nextNode);



var interfaces;
if(type !== node && (interfaces = typeInterfaceMap[type])){
if(interfaces[node]){
type = node;}}




currentType.push(type);

if(node !== type){
return false;}



if(nextNode){

if(nextType && nextNode !== nextType){
return false;}


if(nextValue && !equals(nextValue,nextNode)){
return false;}}


return true;}







function matches(value,node){
if(node.indexOf('|') === -1){
currentType.length = 0;
return equals(value,node);}else
{
var nodes=node.split('|');
for(var i=0;i < nodes.length;i++) {
currentType.length = 0;
if(equals(value,nodes[i])){
return true;}}}



return false;}










function check(){
if(!paused && !disabled){
var args=arguments;
var ii=args.length;
while(ii--) {
var value=args[ii][0];
var expected=args[ii][1];
var name=args[ii][2] || 'return value';

if(!matches(value,expected)){
var actual=currentType.shift();
while(currentType.length) {
actual += '<' + currentType.shift() + '>';}


var isReturn=!!args[ii][2];
var stackBoundary;
try{
stackBoundary = isReturn?arguments.callee.caller:check;}
catch(e) {}




var message=
'Type Mismatch for ' + name + ': expected `' + expected + '`, ' +
'actual `' + actual + '` (' + toStringFunc.call(value) + ').';




if(actual === 'object' &&
expected.match(/^[A-Z]/) &&
!value.__TCmeta){
message +=
' Check the constructor\'s module is marked as typechecked -' +
' see http://fburl.com/typechecks for more information.';}


var error=new TypeError(message);

if(Error.captureStackTrace){
Error.captureStackTrace(error,stackBoundary || check);}else
{


error.framesToPop = isReturn?2:1;}


if(typeof handler == 'function'){
handler(error);

paused = true;

setTimeout(function(){return paused = false;},0);}else
if(handler === 'throw'){
throw error;}}}}






return arguments[0][0];}






check.setHandler = function(fn){
handler = fn;};


check.disable = function(){
disabled = true;};





function annotate(fn,meta){
meta.superClass = fn.__superConstructor__;
fn.__TCmeta = meta;
return fn;}



__t = check;
__w = annotate;})();
/** Path: html/js/downstream/require/require-lite.js */
/**
 * @generated SignedSource<<c96a4931770595939d7f79714b4bfabb>>
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !! This file is a check-in of a static_upstream project!      !!
 * !!                                                            !!
 * !! You should not modify this file directly. Instead:         !!
 * !! 1) Use `fjs use-upstream` to temporarily replace this with !!
 * !!    the latest version from upstream.                       !!
 * !! 2) Make your changes, test them, etc.                      !!
 * !! 3) Use `fjs push-upstream` to copy your changes back to    !!
 * !!    static_upstream.                                        !!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * This is a lightweigh implementation of require and __d which is used by the
 * JavaScript SDK.
 * This implementation requires that all modules are defined in order by how
 * they depend on each other, so that it is guaranteed that no module will
 * require a module that has not got all of its dependencies satisfied.
 * This means that it is generally only usable in cases where all resources are
 * resolved and packaged together.
 *
 * @providesInline commonjs-require-lite
 * @typechecks
 */

var require,__d;
(function(global){
var map={},resolved={};
var defaultDeps=
['global','require','requireDynamic','requireLazy','module','exports'];

require = function(id,soft){
if(resolved.hasOwnProperty(id)){
return resolved[id];}

if(!map.hasOwnProperty(id)){
if(soft){
return null;}

throw new Error('Module ' + id + ' has not been defined');}

var module=map[id],
deps=module.deps,
length=module.factory.length,
dep,
args=[];

for(var i=0;i < length;i++) {
switch(deps[i]){
case 'module':dep = module;break;
case 'exports':dep = module.exports;break;
case 'global':dep = global;break;
case 'require':dep = require;break;
case 'requireDynamic':dep = null;break;
case 'requireLazy':dep = null;break;
default:dep = require.call(null,deps[i]);}

args.push(dep);}

module.factory.apply(global,args);
resolved[id] = module.exports;
return module.exports;};




require.__markCompiled = function(){};

__d = function(id,deps,factory,
_special){
if(typeof factory == 'function'){
map[id] = {
factory:factory,
deps:defaultDeps.concat(deps),
exports:{}};



if(_special === 3){
require.call(null,id);}}else

{
resolved[id] = factory;}};})(


this);
/** Path: html/js/sdk/ES5Array.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES5Array
 */__d('ES5Array',[],__annotator(function $module_ES5Array(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var ES5Array={};

ES5Array.isArray = __annotator(function(object){
return Object.prototype.toString.call(object) == '[object Array]';},{'module':'ES5Array','line':9,'column':19,'endLine':11,'endColumn':1});


module.exports = ES5Array;},{'module':'ES5Array','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES5Array'}),null);
/** Path: html/js/sdk/ES5ArrayPrototype.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES5ArrayPrototype
 */__d('ES5ArrayPrototype',[],__annotator(function $module_ES5ArrayPrototype(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var ES5ArrayPrototype={};




ES5ArrayPrototype.map = __annotator(function(func,context){
if(typeof func != 'function'){
throw new TypeError();}


var ii;
var len=this.length;
var r=new Array(len);
for(ii = 0;ii < len;++ii) {
if(ii in this){
r[ii] = func.call(context,this[ii],ii,this);}}



return r;},{'module':'ES5ArrayPrototype','line':12,'column':24,'endLine':27,'endColumn':1});





ES5ArrayPrototype.forEach = __annotator(function(func,context){
ES5ArrayPrototype.map.call(this,func,context);},{'module':'ES5ArrayPrototype','line':32,'column':28,'endLine':34,'endColumn':1});





ES5ArrayPrototype.filter = __annotator(function(func,context){
if(typeof func != 'function'){
throw new TypeError();}


var ii,val,len=this.length,r=[];
for(ii = 0;ii < len;++ii) {
if(ii in this){

val = this[ii];
if(func.call(context,val,ii,this)){
r.push(val);}}}




return r;},{'module':'ES5ArrayPrototype','line':39,'column':27,'endLine':56,'endColumn':1});





ES5ArrayPrototype.every = __annotator(function(func,context){
if(typeof func != 'function'){
throw new TypeError();}

var t=new Object(this);
var len=t.length;
for(var ii=0;ii < len;ii++) {
if(ii in t){
if(!func.call(context,t[ii],ii,t)){
return false;}}}



return true;},{'module':'ES5ArrayPrototype','line':61,'column':26,'endLine':75,'endColumn':1});





ES5ArrayPrototype.some = __annotator(function(func,context){
if(typeof func != 'function'){
throw new TypeError();}

var t=new Object(this);
var len=t.length;
for(var ii=0;ii < len;ii++) {
if(ii in t){
if(func.call(context,t[ii],ii,t)){
return true;}}}



return false;},{'module':'ES5ArrayPrototype','line':80,'column':25,'endLine':94,'endColumn':1});





ES5ArrayPrototype.indexOf = __annotator(function(val,index){
var len=this.length;
index |= 0;

if(index < 0){
index += len;}


for(;index < len;index++) {
if(index in this && this[index] === val){
return index;}}


return -1;},{'module':'ES5ArrayPrototype','line':99,'column':28,'endLine':113,'endColumn':1});


module.exports = ES5ArrayPrototype;},{'module':'ES5ArrayPrototype','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES5ArrayPrototype'}),null);
/** Path: html/js/sdk/ES5Date.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES5Date
 */__d("ES5Date",[],__annotator(function $module_ES5Date(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var ES5Date={};
ES5Date.now = __annotator(function(){
return new Date().getTime();},{"module":"ES5Date","line":8,"column":14,"endLine":10,"endColumn":1});


module.exports = ES5Date;},{"module":"ES5Date","line":0,"column":0,"endLine":0,"endColumn":0,"name":"$module_ES5Date"}),null);
/** Path: html/js/sdk/ES5FunctionPrototype.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES5FunctionPrototype
 */__d('ES5FunctionPrototype',[],__annotator(function $module_ES5FunctionPrototype(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var ES5FunctionPrototype={};









ES5FunctionPrototype.bind = __annotator(function(context){
if(typeof this != 'function'){
throw new TypeError('Bind must be called on a function');}

var target=this;
var appliedArguments=Array.prototype.slice.call(arguments,1);
function bound(){
return target.apply(
context,
appliedArguments.concat(Array.prototype.slice.call(arguments)));}__annotator(bound,{'module':'ES5FunctionPrototype','line':23,'column':2,'endLine':27,'endColumn':3,'name':'bound'});

bound.displayName = 'bound:' + (target.displayName || target.name || '(?)');
bound.toString = __annotator(function toString(){
return 'bound: ' + target;},{'module':'ES5FunctionPrototype','line':29,'column':19,'endLine':31,'endColumn':3,'name':'toString'});

return bound;},{'module':'ES5FunctionPrototype','line':17,'column':28,'endLine':33,'endColumn':1});


module.exports = ES5FunctionPrototype;},{'module':'ES5FunctionPrototype','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES5FunctionPrototype'}),null);
/** Path: html/js/ie8DontEnum.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ie8DontEnum
 */__d('ie8DontEnum',[],__annotator(function $module_ie8DontEnum(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();



var dontEnumProperties=[
'toString',
'toLocaleString',
'valueOf',
'hasOwnProperty',
'isPrototypeOf',
'prototypeIsEnumerable',
'constructor'];


var hasOwnProperty=({}).hasOwnProperty;





var ie8DontEnum=__annotator(function(){},{'module':'ie8DontEnum','line':25,'column':18,'endLine':25,'endColumn':31});

if(({toString:true}).propertyIsEnumerable('toString')){
ie8DontEnum = __annotator(function(object,onProp){
for(var i=0;i < dontEnumProperties.length;i++) {
var property=dontEnumProperties[i];
if(hasOwnProperty.call(object,property)){
onProp(property);}}},{'module':'ie8DontEnum','line':28,'column':16,'endLine':35,'endColumn':3});}





module.exports = ie8DontEnum;},{'module':'ie8DontEnum','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ie8DontEnum'}),null);
/** Path: html/js/sdk/ES5Object.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES5Object
 */__d('ES5Object',['ie8DontEnum'],__annotator(function $module_ES5Object(global,require,requireDynamic,requireLazy,module,exports,ie8DontEnum){if(require.__markCompiled)require.__markCompiled();


var hasOwnProperty=({}).hasOwnProperty;

var ES5Object={};



function F(){}__annotator(F,{'module':'ES5Object','line':14,'column':0,'endLine':14,'endColumn':15,'name':'F'});






ES5Object.create = __annotator(function(proto){
if(__DEV__){
if(arguments.length > 1){
throw new Error(
'Object.create implementation supports only the first parameter');}}


var type=typeof proto;
if(type != 'object' && type != 'function'){
throw new TypeError('Object prototype may only be a Object or null');}

F.prototype = proto;
return new F();},{'module':'ES5Object','line':21,'column':19,'endLine':34,'endColumn':1});







ES5Object.keys = __annotator(function(object){
var type=typeof object;
if(type != 'object' && type != 'function' || object === null){
throw new TypeError('Object.keys called on non-object');}


var keys=[];
for(var key in object) {
if(hasOwnProperty.call(object,key)){
keys.push(key);}}




ie8DontEnum(object,__annotator(function(prop){return keys.push(prop);},{'module':'ES5Object','line':55,'column':22,'endLine':55,'endColumn':45}));

return keys;},{'module':'ES5Object','line':41,'column':17,'endLine':58,'endColumn':1});


module.exports = ES5Object;},{'module':'ES5Object','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES5Object'}),null);
/** Path: html/js/sdk/ES5StringPrototype.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES5StringPrototype
 */__d('ES5StringPrototype',[],__annotator(function $module_ES5StringPrototype(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var ES5StringPrototype={};






ES5StringPrototype.trim = __annotator(function(){
if(this == null){
throw new TypeError('String.prototype.trim called on null or undefined');}

return String.prototype.replace.call(this,/^\s+|\s+$/g,'');},{'module':'ES5StringPrototype','line':14,'column':26,'endLine':19,'endColumn':1});


ES5StringPrototype.startsWith = __annotator(function(search){
var string=String(this);
if(this == null){
throw new TypeError(
'String.prototype.startsWith called on null or undefined');}

var pos=arguments.length > 1?Number(arguments[1]):0;
if(isNaN(pos)){
pos = 0;}

var start=Math.min(Math.max(pos,0),string.length);
return string.indexOf(String(search),pos) == start;},{'module':'ES5StringPrototype','line':21,'column':32,'endLine':33,'endColumn':1});


ES5StringPrototype.endsWith = __annotator(function(search){
var string=String(this);
if(this == null){
throw new TypeError(
'String.prototype.endsWith called on null or undefined');}

var stringLength=string.length;
var searchString=String(search);
var pos=arguments.length > 1?Number(arguments[1]):stringLength;
if(isNaN(pos)){
pos = 0;}

var end=Math.min(Math.max(pos,0),stringLength);
var start=end - searchString.length;
if(start < 0){
return false;}

return string.lastIndexOf(searchString,start) == start;},{'module':'ES5StringPrototype','line':35,'column':30,'endLine':53,'endColumn':1});


ES5StringPrototype.contains = __annotator(function(search){
if(this == null){
throw new TypeError(
'String.prototype.contains called on null or undefined');}

var string=String(this);
var pos=arguments.length > 1?Number(arguments[1]):0;
if(isNaN(pos)){
pos = 0;}

return string.indexOf(String(search),pos) != -1;},{'module':'ES5StringPrototype','line':55,'column':30,'endLine':66,'endColumn':1});


ES5StringPrototype.repeat = __annotator(function(count){
if(this == null){
throw new TypeError(
'String.prototype.repeat called on null or undefined');}

var string=String(this);
var n=count?Number(count):0;
if(isNaN(n)){
n = 0;}

if(n < 0 || n === Infinity){
throw RangeError();}

if(n === 1){
return string;}

if(n === 0){
return '';}

var result='';
while(n) {
if(n & 1){
result += string;}

if(n >>= 1){
string += string;}}


return result;},{'module':'ES5StringPrototype','line':68,'column':28,'endLine':97,'endColumn':1});


module.exports = ES5StringPrototype;},{'module':'ES5StringPrototype','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES5StringPrototype'}),null);
/** Path: html/js/sdk/ES6Array.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES6Array
 */__d('ES6Array',[],__annotator(function $module_ES6Array(global,require,requireDynamic,requireLazy,module,exports){

'use strict';if(require.__markCompiled)require.__markCompiled();

var ES6Array={

from:__annotator(function(arrayLike){
if(arrayLike == null){
throw new TypeError('Object is null or undefined');}



var mapFn=arguments[1];
var thisArg=arguments[2];

var C=this;
var items=Object(arrayLike);
var symbolIterator=typeof Symbol === 'function'?typeof Symbol === 'function'?
Symbol.iterator:'@@iterator':
'@@iterator';
var mapping=typeof mapFn === 'function';
var usingIterator=typeof items[symbolIterator] === 'function';
var key=0;
var ret;
var value;

if(usingIterator){
ret = typeof C === 'function'?
new C():
[];
var it=items[symbolIterator]();
var next;

while(!(next = it.next()).done) {
value = next.value;

if(mapping){
value = mapFn.call(thisArg,value,key);}


ret[key] = value;
key += 1;}


ret.length = key;
return ret;}


var len=items.length;
if(isNaN(len) || len < 0){
len = 0;}


ret = typeof C === 'function'?
new C(len):
new Array(len);

while(key < len) {
value = items[key];

if(mapping){
value = mapFn.call(thisArg,value,key);}


ret[key] = value;

key += 1;}


ret.length = key;
return ret;},{'module':'ES6Array','line':11,'column':6,'endLine':76,'endColumn':3})};




module.exports = ES6Array;},{'module':'ES6Array','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES6Array'}),null);
/** Path: html/js/sdk/ES6ArrayPrototype.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES6ArrayPrototype
 */__d('ES6ArrayPrototype',[],__annotator(function $module_ES6ArrayPrototype(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();




var ES6ArrayPrototype={




find:__annotator(function(predicate,thisArg){
if(this == null){
throw new TypeError('Array.prototype.find called on null or undefined');}

if(typeof predicate !== 'function'){
throw new TypeError('predicate must be a function');}


var index=ES6ArrayPrototype.findIndex.call(this,predicate,thisArg);
return index === -1?void 0:this[index];},{'module':'ES6ArrayPrototype','line':15,'column':6,'endLine':25,'endColumn':3}),






findIndex:__annotator(function(predicate,thisArg){
if(this == null){
throw new TypeError(
'Array.prototype.findIndex called on null or undefined');}


if(typeof predicate !== 'function'){
throw new TypeError('predicate must be a function');}

var list=Object(this);
var length=list.length >>> 0;
for(var i=0;i < length;i++) {
if(predicate.call(thisArg,list[i],i,list)){
return i;}}


return -1;},{'module':'ES6ArrayPrototype','line':31,'column':11,'endLine':48,'endColumn':3}),






fill:__annotator(function(value){
if(this == null){
throw new TypeError('Array.prototype.fill called on null or undefined');}

var O=Object(this);
var len=O.length >>> 0;
var start=arguments[1];
var relativeStart=start >> 0;
var k=relativeStart < 0?
Math.max(len + relativeStart,0):
Math.min(relativeStart,len);
var end=arguments[2];
var relativeEnd=end === undefined?
len:
end >> 0;
var final=relativeEnd < 0?
Math.max(len + relativeEnd,0):
Math.min(relativeEnd,len);
while(k < final) {
O[k] = value;
k++;}

return O;},{'module':'ES6ArrayPrototype','line':54,'column':6,'endLine':77,'endColumn':3})};



module.exports = ES6ArrayPrototype;},{'module':'ES6ArrayPrototype','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES6ArrayPrototype'}),null);
/** Path: html/js/sdk/ES6DatePrototype.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES6DatePrototype
 */__d('ES6DatePrototype',[],__annotator(function $module_ES6DatePrototype(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function pad(number){
return (number < 10?'0':'') + number;}__annotator(pad,{'module':'ES6DatePrototype','line':7,'column':0,'endLine':9,'endColumn':1,'name':'pad'});


var ES6DatePrototype={



toISOString:__annotator(function(){
if(!isFinite(this)){
throw new Error('Invalid time value');}

var year=this.getUTCFullYear();
year = (year < 0?'-':year > 9999?'+':'') +
('00000' + Math.abs(year)).slice(0 <= year && year <= 9999?-4:-6);
return year +
'-' + pad(this.getUTCMonth() + 1) +
'-' + pad(this.getUTCDate()) +
'T' + pad(this.getUTCHours()) +
':' + pad(this.getUTCMinutes()) +
':' + pad(this.getUTCSeconds()) +
'.' + (this.getUTCMilliseconds() / 1000).toFixed(3).slice(2,5) +
'Z';},{'module':'ES6DatePrototype','line':15,'column':13,'endLine':30,'endColumn':3})};



module.exports = ES6DatePrototype;},{'module':'ES6DatePrototype','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES6DatePrototype'}),null);
/** Path: html/js/sdk/ES6Number.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES6Number
 */__d('ES6Number',[],__annotator(function $module_ES6Number(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var EPSILON=Math.pow(2,-52);
var MAX_SAFE_INTEGER=Math.pow(2,53) - 1;
var MIN_SAFE_INTEGER=-1 * MAX_SAFE_INTEGER;

var ES6Number={
isFinite:__annotator(function(value){
return typeof value == 'number' && isFinite(value);},{'module':'ES6Number','line':12,'column':10,'endLine':14,'endColumn':3}),


isNaN:__annotator(function(value){
return typeof value == 'number' && isNaN(value);},{'module':'ES6Number','line':16,'column':7,'endLine':18,'endColumn':3}),


isInteger:__annotator(function(value){
return this.isFinite(value) &&
Math.floor(value) === value;},{'module':'ES6Number','line':20,'column':11,'endLine':23,'endColumn':3}),


isSafeInteger:__annotator(function(value){
return this.isFinite(value) &&
value >= this.MIN_SAFE_INTEGER &&
value <= this.MAX_SAFE_INTEGER &&
Math.floor(value) === value;},{'module':'ES6Number','line':25,'column':15,'endLine':30,'endColumn':3}),


EPSILON:EPSILON,
MAX_SAFE_INTEGER:MAX_SAFE_INTEGER,
MIN_SAFE_INTEGER:MIN_SAFE_INTEGER};


module.exports = ES6Number;},{'module':'ES6Number','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES6Number'}),null);
/** Path: html/js/sdk/ES6Object.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES6Object
 */__d('ES6Object',['ie8DontEnum'],__annotator(function $module_ES6Object(global,require,requireDynamic,requireLazy,module,exports,ie8DontEnum){if(require.__markCompiled)require.__markCompiled();


var hasOwnProperty=({}).hasOwnProperty;

var ES6Object={





assign:__annotator(function(target){
if(target == null){
throw new TypeError('Object.assign target cannot be null or undefined');}


target = Object(target);for(var _len=arguments.length,sources=Array(_len > 1?_len - 1:0),_key=1;_key < _len;_key++) {sources[_key - 1] = arguments[_key];}

for(var i=0;i < sources.length;i++) {
var source=sources[i];

if(source == null){
continue;}


source = Object(source);

for(var prop in source) {
if(hasOwnProperty.call(source,prop)){
target[prop] = source[prop];}}




ie8DontEnum(source,__annotator(function(prop){return target[prop] = source[prop];},{'module':'ES6Object','line':39,'column':26,'endLine':39,'endColumn':63}));}


return target;},{'module':'ES6Object','line':16,'column':8,'endLine':43,'endColumn':3}),







is:__annotator(function(x,y){
if(x === y){

return x !== 0 || 1 / x === 1 / y;}else
{

return x !== x && y !== y;}},{'module':'ES6Object','line':50,'column':4,'endLine':58,'endColumn':3})};




module.exports = ES6Object;},{'module':'ES6Object','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES6Object'}),null);
/** Path: html/js/sdk/ES7StringPrototype.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES7StringPrototype
 */__d('ES7StringPrototype',[],__annotator(function $module_ES7StringPrototype(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var ES7StringPrototype={};

ES7StringPrototype.trimLeft = __annotator(function(){
return this.replace(/^\s+/,'');},{'module':'ES7StringPrototype','line':9,'column':30,'endLine':11,'endColumn':1});


ES7StringPrototype.trimRight = __annotator(function(){
return this.replace(/\s+$/,'');},{'module':'ES7StringPrototype','line':13,'column':31,'endLine':15,'endColumn':1});


module.exports = ES7StringPrototype;},{'module':'ES7StringPrototype','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES7StringPrototype'}),null);
/** Path: html/js/third_party/json3/json3.js */
/**
 * @providesModule JSON3
 * @preserve-header
 *
 *! JSON v3.2.3 | http://bestiejs.github.com/json3 | Copyright 2012, Kit Cambridge | http://kit.mit-license.org
 */
__d("JSON3",[],function $module_JSON3(global,require,requireDynamic,requireLazy,module,exports){require.__markCompiled && require.__markCompiled();
;(function () {
  // Convenience aliases.
  var getClass = {}.toString, isProperty, forEach, undef;
  var JSON3 = module.exports = {};
  // A JSON source string used to test the native `stringify` and `parse`
  // implementations.
  var serialized = '{"A":[1,true,false,null,"\\u0000\\b\\n\\f\\r\\t"]}';

  // Feature tests to determine whether the native `JSON.stringify` and `parse`
  // implementations are spec-compliant. Based on work by Ken Snyder.
  var stringifySupported, Escapes, toPaddedString, quote, serialize;
  var parseSupported, fromCharCode, Unescapes, abort, lex, get, walk, update, Index, Source;

  // Test the `Date#getUTC*` methods. Based on work by @Yaffle.
  var value = new Date(-3509827334573292), floor, Months, getDay;

  try {
    // The `getUTCFullYear`, `Month`, and `Date` methods return nonsensical
    // results for certain dates in Opera >= 10.53.
    value = value.getUTCFullYear() == -109252 && value.getUTCMonth() === 0 && value.getUTCDate() == 1 &&
      // Safari < 2.0.2 stores the internal millisecond time value correctly,
      // but clips the values returned by the date methods to the range of
      // signed 32-bit integers ([-2 ** 31, 2 ** 31 - 1]).
      value.getUTCHours() == 10 && value.getUTCMinutes() == 37 && value.getUTCSeconds() == 6 && value.getUTCMilliseconds() == 708;
  } catch (exception) {}

  // Define additional utility methods if the `Date` methods are buggy.
  if (!value) {
    floor = Math.floor;
    // A mapping between the months of the year and the number of days between
    // January 1st and the first of the respective month.
    Months = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
    // Internal: Calculates the number of days between the Unix epoch and the
    // first day of the given month.
    getDay = function (year, month) {
      return Months[month] + 365 * (year - 1970) + floor((year - 1969 + (month = +(month > 1))) / 4) - floor((year - 1901 + month) / 100) + floor((year - 1601 + month) / 400);
    };
  }

  if (typeof JSON == "object" && JSON) {
    // Delegate to the native `stringify` and `parse` implementations in
    // asynchronous module loaders and CommonJS environments.
    JSON3.stringify = JSON.stringify;
    JSON3.parse = JSON.parse;
  }

  // Test `JSON.stringify`.
  if ((stringifySupported = typeof JSON3.stringify == "function" && !getDay)) {
    // A test function object with a custom `toJSON` method.
    (value = function () {
      return 1;
    }).toJSON = value;
    try {
      stringifySupported =
        // Firefox 3.1b1 and b2 serialize string, number, and boolean
        // primitives as object literals.
        JSON3.stringify(0) === "0" &&
        // FF 3.1b1, b2, and JSON 2 serialize wrapped primitives as object
        // literals.
        JSON3.stringify(new Number()) === "0" &&
        JSON3.stringify(new String()) == '""' &&
        // FF 3.1b1, 2 throw an error if the value is `null`, `undefined`, or
        // does not define a canonical JSON representation (this applies to
        // objects with `toJSON` properties as well, *unless* they are nested
        // within an object or array).
        JSON3.stringify(getClass) === undef &&
        // IE 8 serializes `undefined` as `"undefined"`. Safari 5.1.2 and FF
        // 3.1b3 pass this test.
        JSON3.stringify(undef) === undef &&
        // Safari 5.1.2 and FF 3.1b3 throw `Error`s and `TypeError`s,
        // respectively, if the value is omitted entirely.
        JSON3.stringify() === undef &&
        // FF 3.1b1, 2 throw an error if the given value is not a number,
        // string, array, object, Boolean, or `null` literal. This applies to
        // objects with custom `toJSON` methods as well, unless they are nested
        // inside object or array literals. YUI 3.0.0b1 ignores custom `toJSON`
        // methods entirely.
        JSON3.stringify(value) === "1" &&
        JSON3.stringify([value]) == "[1]" &&
        // Prototype <= 1.6.1 serializes `[undefined]` as `"[]"` instead of
        // `"[null]"`.
        JSON3.stringify([undef]) == "[null]" &&
        // YUI 3.0.0b1 fails to serialize `null` literals.
        JSON3.stringify(null) == "null" &&
        // FF 3.1b1, 2 halts serialization if an array contains a function:
        // `[1, true, getClass, 1]` serializes as "[1,true,],". These versions
        // of Firefox also allow trailing commas in JSON objects and arrays.
        // FF 3.1b3 elides non-JSON values from objects and arrays, unless they
        // define custom `toJSON` methods.
        JSON3.stringify([undef, getClass, null]) == "[null,null,null]" &&
        // Simple serialization test. FF 3.1b1 uses Unicode escape sequences
        // where character escape codes are expected (e.g., `\b` => `\u0008`).
        JSON3.stringify({ "result": [value, true, false, null, "\0\b\n\f\r\t"] }) == serialized &&
        // FF 3.1b1 and b2 ignore the `filter` and `width` arguments.
        JSON3.stringify(null, value) === "1" &&
        JSON3.stringify([1, 2], null, 1) == "[\n 1,\n 2\n]" &&
        // JSON 2, Prototype <= 1.7, and older WebKit builds incorrectly
        // serialize extended years.
        JSON3.stringify(new Date(-8.64e15)) == '"-271821-04-20T00:00:00.000Z"' &&
        // The milliseconds are optional in ES 5, but required in 5.1.
        JSON3.stringify(new Date(8.64e15)) == '"+275760-09-13T00:00:00.000Z"' &&
        // Firefox <= 11.0 incorrectly serializes years prior to 0 as negative
        // four-digit years instead of six-digit years. Credits: @Yaffle.
        JSON3.stringify(new Date(-621987552e5)) == '"-000001-01-01T00:00:00.000Z"' &&
        // Safari <= 5.1.5 and Opera >= 10.53 incorrectly serialize millisecond
        // values less than 1000. Credits: @Yaffle.
        JSON3.stringify(new Date(-1)) == '"1969-12-31T23:59:59.999Z"';
    } catch (exception) {
      stringifySupported = false;
    }
  }

  // Test `JSON.parse`.
  if (typeof JSON3.parse == "function") {
    try {
      // FF 3.1b1, b2 will throw an exception if a bare literal is provided.
      // Conforming implementations should also coerce the initial argument to
      // a string prior to parsing.
      if (JSON3.parse("0") === 0 && !JSON3.parse(false)) {
        // Simple parsing test.
        value = JSON3.parse(serialized);
        if ((parseSupported = value.A.length == 5 && value.A[0] == 1)) {
          try {
            // Safari <= 5.1.2 and FF 3.1b1 allow unescaped tabs in strings.
            parseSupported = !JSON3.parse('"\t"');
          } catch (exception) {}
          if (parseSupported) {
            try {
              // FF 4.0 and 4.0.1 allow leading `+` signs, and leading and
              // trailing decimal points. FF 4.0, 4.0.1, and IE 9 also allow
              // certain octal literals.
              parseSupported = JSON3.parse("01") != 1;
            } catch (exception) {}
          }
        }
      }
    } catch (exception) {
      parseSupported = false;
    }
  }

  // Clean up the variables used for the feature tests.
  value = serialized = null;

  if (!stringifySupported || !parseSupported) {
    // Internal: Determines if a property is a direct property of the given
    // object. Delegates to the native `Object#hasOwnProperty` method.
    if (!(isProperty = {}.hasOwnProperty)) {
      isProperty = function (property) {
        var members = {}, constructor;
        if ((members.__proto__ = null, members.__proto__ = {
          // The *proto* property cannot be set multiple times in recent
          // versions of Firefox and SeaMonkey.
          "toString": 1
        }, members).toString != getClass) {
          // Safari <= 2.0.3 doesn't implement `Object#hasOwnProperty`, but
          // supports the mutable *proto* property.
          isProperty = function (property) {
            // Capture and break the object's prototype chain (see section 8.6.2
            // of the ES 5.1 spec). The parenthesized expression prevents an
            // unsafe transformation by the Closure Compiler.
            var original = this.__proto__, result = property in (this.__proto__ = null, this);
            // Restore the original prototype chain.
            this.__proto__ = original;
            return result;
          };
        } else {
          // Capture a reference to the top-level `Object` constructor.
          constructor = members.constructor;
          // Use the `constructor` property to simulate `Object#hasOwnProperty` in
          // other environments.
          isProperty = function (property) {
            var parent = (this.constructor || constructor).prototype;
            return property in this && !(property in parent && this[property] === parent[property]);
          };
        }
        members = null;
        return isProperty.call(this, property);
      };
    }

    // Internal: Normalizes the `for...in` iteration algorithm across
    // environments. Each enumerated key is yielded to a `callback` function.
    forEach = function (object, callback) {
      var size = 0, Properties, members, property, forEach;

      // Tests for bugs in the current environment's `for...in` algorithm. The
      // `valueOf` property inherits the non-enumerable flag from
      // `Object.prototype` in older versions of IE, Netscape, and Mozilla.
      (Properties = function () {
        this.valueOf = 0;
      }).prototype.valueOf = 0;

      // Iterate over a new instance of the `Properties` class.
      members = new Properties();
      for (property in members) {
        // Ignore all properties inherited from `Object.prototype`.
        if (isProperty.call(members, property)) {
          size++;
        }
      }
      Properties = members = null;

      // Normalize the iteration algorithm.
      if (!size) {
        // A list of non-enumerable properties inherited from `Object.prototype`.
        members = ["valueOf", "toString", "toLocaleString", "propertyIsEnumerable", "isPrototypeOf", "hasOwnProperty", "constructor"];
        // IE <= 8, Mozilla 1.0, and Netscape 6.2 ignore shadowed non-enumerable
        // properties.
        forEach = function (object, callback) {
          var isFunction = getClass.call(object) == "[object Function]", property, length;
          for (property in object) {
            // Gecko <= 1.0 enumerates the `prototype` property of functions under
            // certain conditions; IE does not.
            if (!(isFunction && property == "prototype") && isProperty.call(object, property)) {
              callback(property);
            }
          }
          // Manually invoke the callback for each non-enumerable property.
          for (length = members.length; property = members[--length]; isProperty.call(object, property) && callback(property));
        };
      } else if (size == 2) {
        // Safari <= 2.0.4 enumerates shadowed properties twice.
        forEach = function (object, callback) {
          // Create a set of iterated properties.
          var members = {}, isFunction = getClass.call(object) == "[object Function]", property;
          for (property in object) {
            // Store each property name to prevent double enumeration. The
            // `prototype` property of functions is not enumerated due to cross-
            // environment inconsistencies.
            if (!(isFunction && property == "prototype") && !isProperty.call(members, property) && (members[property] = 1) && isProperty.call(object, property)) {
              callback(property);
            }
          }
        };
      } else {
        // No bugs detected; use the standard `for...in` algorithm.
        forEach = function (object, callback) {
          var isFunction = getClass.call(object) == "[object Function]", property, isConstructor;
          for (property in object) {
            if (!(isFunction && property == "prototype") && isProperty.call(object, property) && !(isConstructor = property === "constructor")) {
              callback(property);
            }
          }
          // Manually invoke the callback for the `constructor` property due to
          // cross-environment inconsistencies.
          if (isConstructor || isProperty.call(object, (property = "constructor"))) {
            callback(property);
          }
        };
      }
      return forEach(object, callback);
    };

    // Public: Serializes a JavaScript `value` as a JSON string. The optional
    // `filter` argument may specify either a function that alters how object and
    // array members are serialized, or an array of strings and numbers that
    // indicates which properties should be serialized. The optional `width`
    // argument may be either a string or number that specifies the indentation
    // level of the output.
    if (!stringifySupported) {
      // Internal: A map of control characters and their escaped equivalents.
      Escapes = {
        "\\": "\\\\",
        '"': '\\"',
        "\b": "\\b",
        "\f": "\\f",
        "\n": "\\n",
        "\r": "\\r",
        "\t": "\\t"
      };

      // Internal: Converts `value` into a zero-padded string such that its
      // length is at least equal to `width`. The `width` must be <= 6.
      toPaddedString = function (width, value) {
        // The `|| 0` expression is necessary to work around a bug in
        // Opera <= 7.54u2 where `0 == -0`, but `String(-0) !== "0"`.
        return ("000000" + (value || 0)).slice(-width);
      };

      // Internal: Double-quotes a string `value`, replacing all ASCII control
      // characters (characters with code unit values between 0 and 31) with
      // their escaped equivalents. This is an implementation of the
      // `Quote(value)` operation defined in ES 5.1 section 15.12.3.
      quote = function (value) {
        var result = '"', index = 0, symbol;
        for (; symbol = value.charAt(index); index++) {
          // Escape the reverse solidus, double quote, backspace, form feed, line
          // feed, carriage return, and tab characters.
          result += '\\"\b\f\n\r\t'.indexOf(symbol) > -1 ? Escapes[symbol] :
            // If the character is a control character, append its Unicode escape
            // sequence; otherwise, append the character as-is.
            symbol < " " ? "\\u00" + toPaddedString(2, symbol.charCodeAt(0).toString(16)) : symbol;
        }
        return result + '"';
      };

      // Internal: Recursively serializes an object. Implements the
      // `Str(key, holder)`, `JO(value)`, and `JA(value)` operations.
      serialize = function (property, object, callback, properties, whitespace, indentation, stack) {
        var value = object[property], className, year, month, date, time, hours, minutes, seconds, milliseconds, results, element, index, length, prefix, any;
        if (typeof value == "object" && value) {
          className = getClass.call(value);
          if (className == "[object Date]" && !isProperty.call(value, "toJSON")) {
            if (value > -1 / 0 && value < 1 / 0) {
              // Dates are serialized according to the `Date#toJSON` method
              // specified in ES 5.1 section 15.9.5.44. See section 15.9.1.15
              // for the ISO 8601 date time string format.
              if (getDay) {
                // Manually compute the year, month, date, hours, minutes,
                // seconds, and milliseconds if the `getUTC*` methods are
                // buggy. Adapted from @Yaffle's `date-shim` project.
                date = floor(value / 864e5);
                for (year = floor(date / 365.2425) + 1970 - 1; getDay(year + 1, 0) <= date; year++);
                for (month = floor((date - getDay(year, 0)) / 30.42); getDay(year, month + 1) <= date; month++);
                date = 1 + date - getDay(year, month);
                // The `time` value specifies the time within the day (see ES
                // 5.1 section 15.9.1.2). The formula `(A % B + B) % B` is used
                // to compute `A modulo B`, as the `%` operator does not
                // correspond to the `modulo` operation for negative numbers.
                time = (value % 864e5 + 864e5) % 864e5;
                // The hours, minutes, seconds, and milliseconds are obtained by
                // decomposing the time within the day. See section 15.9.1.10.
                hours = floor(time / 36e5) % 24;
                minutes = floor(time / 6e4) % 60;
                seconds = floor(time / 1e3) % 60;
                milliseconds = time % 1e3;
              } else {
                year = value.getUTCFullYear();
                month = value.getUTCMonth();
                date = value.getUTCDate();
                hours = value.getUTCHours();
                minutes = value.getUTCMinutes();
                seconds = value.getUTCSeconds();
                milliseconds = value.getUTCMilliseconds();
              }
              // Serialize extended years correctly.
              value = (year <= 0 || year >= 1e4 ? (year < 0 ? "-" : "+") + toPaddedString(6, year < 0 ? -year : year) : toPaddedString(4, year)) +
                "-" + toPaddedString(2, month + 1) + "-" + toPaddedString(2, date) +
                // Months, dates, hours, minutes, and seconds should have two
                // digits; milliseconds should have three.
                "T" + toPaddedString(2, hours) + ":" + toPaddedString(2, minutes) + ":" + toPaddedString(2, seconds) +
                // Milliseconds are optional in ES 5.0, but required in 5.1.
                "." + toPaddedString(3, milliseconds) + "Z";
            } else {
              value = null;
            }
          } else if (typeof value.toJSON == "function" && ((className != "[object Number]" && className != "[object String]" && className != "[object Array]") || isProperty.call(value, "toJSON"))) {
            // Prototype <= 1.6.1 adds non-standard `toJSON` methods to the
            // `Number`, `String`, `Date`, and `Array` prototypes. JSON 3
            // ignores all `toJSON` methods on these objects unless they are
            // defined directly on an instance.
            value = value.toJSON(property);
          }
        }
        if (callback) {
          // If a replacement function was provided, call it to obtain the value
          // for serialization.
          value = callback.call(object, property, value);
        }
        if (value === null) {
          return "null";
        }
        className = getClass.call(value);
        if (className == "[object Boolean]") {
          // Booleans are represented literally.
          return "" + value;
        } else if (className == "[object Number]") {
          // JSON numbers must be finite. `Infinity` and `NaN` are serialized as
          // `"null"`.
          return value > -1 / 0 && value < 1 / 0 ? "" + value : "null";
        } else if (className == "[object String]") {
          // Strings are double-quoted and escaped.
          return quote(value);
        }
        // Recursively serialize objects and arrays.
        if (typeof value == "object") {
          // Check for cyclic structures. This is a linear search; performance
          // is inversely proportional to the number of unique nested objects.
          for (length = stack.length; length--;) {
            if (stack[length] === value) {
              // Cyclic structures cannot be serialized by `JSON.stringify`.
              throw TypeError();
            }
          }
          // Add the object to the stack of traversed objects.
          stack.push(value);
          results = [];
          // Save the current indentation level and indent one additional level.
          prefix = indentation;
          indentation += whitespace;
          if (className == "[object Array]") {
            // Recursively serialize array elements.
            for (index = 0, length = value.length; index < length; any || (any = true), index++) {
              element = serialize(index, value, callback, properties, whitespace, indentation, stack);
              results.push(element === undef ? "null" : element);
            }
            return any ? (whitespace ? "[\n" + indentation + results.join(",\n" + indentation) + "\n" + prefix + "]" : ("[" + results.join(",") + "]")) : "[]";
          } else {
            // Recursively serialize object members. Members are selected from
            // either a user-specified list of property names, or the object
            // itself.
            forEach(properties || value, function (property) {
              var element = serialize(property, value, callback, properties, whitespace, indentation, stack);
              if (element !== undef) {
                // According to ES 5.1 section 15.12.3: "If `gap` {whitespace}
                // is not the empty string, let `member` {quote(property) + ":"}
                // be the concatenation of `member` and the `space` character."
                // The "`space` character" refers to the literal space
                // character, not the `space` {width} argument provided to
                // `JSON.stringify`.
                results.push(quote(property) + ":" + (whitespace ? " " : "") + element);
              }
              any || (any = true);
            });
            return any ? (whitespace ? "{\n" + indentation + results.join(",\n" + indentation) + "\n" + prefix + "}" : ("{" + results.join(",") + "}")) : "{}";
          }
          // Remove the object from the traversed object stack.
          stack.pop();
        }
      };

      // Public: `JSON.stringify`. See ES 5.1 section 15.12.3.
      JSON3.stringify = function (source, filter, width) {
        var whitespace, callback, properties, index, length, value;
        if (typeof filter == "function" || typeof filter == "object" && filter) {
          if (getClass.call(filter) == "[object Function]") {
            callback = filter;
          } else if (getClass.call(filter) == "[object Array]") {
            // Convert the property names array into a makeshift set.
            properties = {};
            for (index = 0, length = filter.length; index < length; value = filter[index++], ((getClass.call(value) == "[object String]" || getClass.call(value) == "[object Number]") && (properties[value] = 1)));
          }
        }
        if (width) {
          if (getClass.call(width) == "[object Number]") {
            // Convert the `width` to an integer and create a string containing
            // `width` number of space characters.
            if ((width -= width % 1) > 0) {
              for (whitespace = "", width > 10 && (width = 10); whitespace.length < width; whitespace += " ");
            }
          } else if (getClass.call(width) == "[object String]") {
            whitespace = width.length <= 10 ? width : width.slice(0, 10);
          }
        }
        // Opera <= 7.54u2 discards the values associated with empty string keys
        // (`""`) only if they are used directly within an object member list
        // (e.g., `!("" in { "": 1})`).
        return serialize("", (value = {}, value[""] = source, value), callback, properties, whitespace, "", []);
      };
    }

    // Public: Parses a JSON source string.
    if (!parseSupported) {
      fromCharCode = String.fromCharCode;
      // Internal: A map of escaped control characters and their unescaped
      // equivalents.
      Unescapes = {
        "\\": "\\",
        '"': '"',
        "/": "/",
        "b": "\b",
        "t": "\t",
        "n": "\n",
        "f": "\f",
        "r": "\r"
      };

      // Internal: Resets the parser state and throws a `SyntaxError`.
      abort = function() {
        Index = Source = null;
        throw SyntaxError();
      };

      // Internal: Returns the next token, or `"$"` if the parser has reached
      // the end of the source string. A token may be a string, number, `null`
      // literal, or Boolean literal.
      lex = function () {
        var source = Source, length = source.length, symbol, value, begin, position, sign;
        while (Index < length) {
          symbol = source.charAt(Index);
          if ("\t\r\n ".indexOf(symbol) > -1) {
            // Skip whitespace tokens, including tabs, carriage returns, line
            // feeds, and space characters.
            Index++;
          } else if ("{}[]:,".indexOf(symbol) > -1) {
            // Parse a punctuator token at the current position.
            Index++;
            return symbol;
          } else if (symbol == '"') {
            // Advance to the next character and parse a JSON string at the
            // current position. String tokens are prefixed with the sentinel
            // `@` character to distinguish them from punctuators.
            for (value = "@", Index++; Index < length;) {
              symbol = source.charAt(Index);
              if (symbol < " ") {
                // Unescaped ASCII control characters are not permitted.
                abort();
              } else if (symbol == "\\") {
                // Parse escaped JSON control characters, `"`, `\`, `/`, and
                // Unicode escape sequences.
                symbol = source.charAt(++Index);
                if ('\\"/btnfr'.indexOf(symbol) > -1) {
                  // Revive escaped control characters.
                  value += Unescapes[symbol];
                  Index++;
                } else if (symbol == "u") {
                  // Advance to the first character of the escape sequence.
                  begin = ++Index;
                  // Validate the Unicode escape sequence.
                  for (position = Index + 4; Index < position; Index++) {
                    symbol = source.charAt(Index);
                    // A valid sequence comprises four hexdigits that form a
                    // single hexadecimal value.
                    if (!(symbol >= "0" && symbol <= "9" || symbol >= "a" && symbol <= "f" || symbol >= "A" && symbol <= "F")) {
                      // Invalid Unicode escape sequence.
                      abort();
                    }
                  }
                  // Revive the escaped character.
                  value += fromCharCode("0x" + source.slice(begin, Index));
                } else {
                  // Invalid escape sequence.
                  abort();
                }
              } else {
                if (symbol == '"') {
                  // An unescaped double-quote character marks the end of the
                  // string.
                  break;
                }
                // Append the original character as-is.
                value += symbol;
                Index++;
              }
            }
            if (source.charAt(Index) == '"') {
              Index++;
              // Return the revived string.
              return value;
            }
            // Unterminated string.
            abort();
          } else {
            // Parse numbers and literals.
            begin = Index;
            // Advance the scanner's position past the sign, if one is
            // specified.
            if (symbol == "-") {
              sign = true;
              symbol = source.charAt(++Index);
            }
            // Parse an integer or floating-point value.
            if (symbol >= "0" && symbol <= "9") {
              // Leading zeroes are interpreted as octal literals.
              if (symbol == "0" && (symbol = source.charAt(Index + 1), symbol >= "0" && symbol <= "9")) {
                // Illegal octal literal.
                abort();
              }
              sign = false;
              // Parse the integer component.
              for (; Index < length && (symbol = source.charAt(Index), symbol >= "0" && symbol <= "9"); Index++);
              // Floats cannot contain a leading decimal point; however, this
              // case is already accounted for by the parser.
              if (source.charAt(Index) == ".") {
                position = ++Index;
                // Parse the decimal component.
                for (; position < length && (symbol = source.charAt(position), symbol >= "0" && symbol <= "9"); position++);
                if (position == Index) {
                  // Illegal trailing decimal.
                  abort();
                }
                Index = position;
              }
              // Parse exponents.
              symbol = source.charAt(Index);
              if (symbol == "e" || symbol == "E") {
                // Skip past the sign following the exponent, if one is
                // specified.
                symbol = source.charAt(++Index);
                if (symbol == "+" || symbol == "-") {
                  Index++;
                }
                // Parse the exponential component.
                for (position = Index; position < length && (symbol = source.charAt(position), symbol >= "0" && symbol <= "9"); position++);
                if (position == Index) {
                  // Illegal empty exponent.
                  abort();
                }
                Index = position;
              }
              // Coerce the parsed value to a JavaScript number.
              return +source.slice(begin, Index);
            }
            // A negative sign may only precede numbers.
            if (sign) {
              abort();
            }
            // `true`, `false`, and `null` literals.
            if (source.slice(Index, Index + 4) == "true") {
              Index += 4;
              return true;
            } else if (source.slice(Index, Index + 5) == "false") {
              Index += 5;
              return false;
            } else if (source.slice(Index, Index + 4) == "null") {
              Index += 4;
              return null;
            }
            // Unrecognized token.
            abort();
          }
        }
        // Return the sentinel `$` character if the parser has reached the end
        // of the source string.
        return "$";
      };

      // Internal: Parses a JSON `value` token.
      get = function (value) {
        var results, any, key;
        if (value == "$") {
          // Unexpected end of input.
          abort();
        }
        if (typeof value == "string") {
          if (value.charAt(0) == "@") {
            // Remove the sentinel `@` character.
            return value.slice(1);
          }
          // Parse object and array literals.
          if (value == "[") {
            // Parses a JSON array, returning a new JavaScript array.
            results = [];
            for (;; any || (any = true)) {
              value = lex();
              // A closing square bracket marks the end of the array literal.
              if (value == "]") {
                break;
              }
              // If the array literal contains elements, the current token
              // should be a comma separating the previous element from the
              // next.
              if (any) {
                if (value == ",") {
                  value = lex();
                  if (value == "]") {
                    // Unexpected trailing `,` in array literal.
                    abort();
                  }
                } else {
                  // A `,` must separate each array element.
                  abort();
                }
              }
              // Elisions and leading commas are not permitted.
              if (value == ",") {
                abort();
              }
              results.push(get(value));
            }
            return results;
          } else if (value == "{") {
            // Parses a JSON object, returning a new JavaScript object.
            results = {};
            for (;; any || (any = true)) {
              value = lex();
              // A closing curly brace marks the end of the object literal.
              if (value == "}") {
                break;
              }
              // If the object literal contains members, the current token
              // should be a comma separator.
              if (any) {
                if (value == ",") {
                  value = lex();
                  if (value == "}") {
                    // Unexpected trailing `,` in object literal.
                    abort();
                  }
                } else {
                  // A `,` must separate each object member.
                  abort();
                }
              }
              // Leading commas are not permitted, object property names must be
              // double-quoted strings, and a `:` must separate each property
              // name and value.
              if (value == "," || typeof value != "string" || value.charAt(0) != "@" || lex() != ":") {
                abort();
              }
              results[value.slice(1)] = get(lex());
            }
            return results;
          }
          // Unexpected token encountered.
          abort();
        }
        return value;
      };

      // Internal: Updates a traversed object member.
      update = function(source, property, callback) {
        var element = walk(source, property, callback);
        if (element === undef) {
          delete source[property];
        } else {
          source[property] = element;
        }
      };

      // Internal: Recursively traverses a parsed JSON object, invoking the
      // `callback` function for each value. This is an implementation of the
      // `Walk(holder, name)` operation defined in ES 5.1 section 15.12.2.
      walk = function (source, property, callback) {
        var value = source[property], length;
        if (typeof value == "object" && value) {
          if (getClass.call(value) == "[object Array]") {
            for (length = value.length; length--;) {
              update(value, length, callback);
            }
          } else {
            // `forEach` can't be used to traverse an array in Opera <= 8.54,
            // as `Object#hasOwnProperty` returns `false` for array indices
            // (e.g., `![1, 2, 3].hasOwnProperty("0")`).
            forEach(value, function (property) {
              update(value, property, callback);
            });
          }
        }
        return callback.call(source, property, value);
      };

      // Public: `JSON.parse`. See ES 5.1 section 15.12.2.
      JSON3.parse = function (source, callback) {
        Index = 0;
        Source = source;
        var result = get(lex());
        // If a JSON string contains multiple tokens, it is invalid.
        if (lex() != "$") {
          abort();
        }
        // Reset the parser state.
        Index = Source = null;
        return callback && getClass.call(callback) == "[object Function]" ? walk((value = {}, value[""] = result, value), "", callback) : result;
      };
    }
  }
}).call(this);

/* 2KL294koxM_ */},null);
/** Path: html/js/sdk/ES.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule ES
 *
 * scripts/jssdk/default.spatch converts ES5/ES6 code into using this module in
 * ES3 style.
 */__d('ES',['ES5ArrayPrototype','ES5FunctionPrototype','ES5StringPrototype','ES5Array','ES5Object','ES5Date','JSON3','ES6Array','ES6Object','ES6ArrayPrototype','ES6DatePrototype','ES6Number','ES7StringPrototype'],__annotator(function $module_ES(global,require,requireDynamic,requireLazy,module,exports,ES5ArrayPrototype,ES5FunctionPrototype,ES5StringPrototype,ES5Array,ES5Object,ES5Date,JSON3,ES6Array,ES6Object,ES6ArrayPrototype,ES6DatePrototype,ES6Number,ES7StringPrototype){if(require.__markCompiled)require.__markCompiled();















var toString=({}).toString;

var methodCache={


'JSON.stringify':JSON3.stringify,
'JSON.parse':JSON3.parse};


var es5Polyfills={
'Array.prototype':ES5ArrayPrototype,
'Function.prototype':ES5FunctionPrototype,
'String.prototype':ES5StringPrototype,
'Object':ES5Object,
'Array':ES5Array,
'Date':ES5Date};


var es6Polyfills={
'Object':ES6Object,
'Array.prototype':ES6ArrayPrototype,
'Date.prototype':ES6DatePrototype,
'Number':ES6Number,
'Array':ES6Array};


var es7Polyfills={
'String.prototype':ES7StringPrototype};


function setupMethodsCache(polyfills){


for(var pName in polyfills) {
if(!polyfills.hasOwnProperty(pName)){continue;}
var polyfillObject=polyfills[pName];


var accessor=pName.split('.');
var nativeObject=accessor.length == 2?
window[accessor[0]][accessor[1]]:
window[pName];


for(var prop in polyfillObject) {
if(!polyfillObject.hasOwnProperty(prop)){continue;}


if(typeof polyfillObject[prop] !== 'function'){
methodCache[pName + '.' + prop] = polyfillObject[prop];
continue;}


var nativeFunction=nativeObject[prop];


methodCache[pName + '.' + prop] =
nativeFunction && /\{\s+\[native code\]\s\}/.test(nativeFunction)?
nativeFunction:
polyfillObject[prop];}}}__annotator(setupMethodsCache,{'module':'ES','line':54,'column':0,'endLine':86,'endColumn':1,'name':'setupMethodsCache'});





setupMethodsCache(es5Polyfills);
setupMethodsCache(es6Polyfills);
setupMethodsCache(es7Polyfills);

function ES(lhs,rhs,proto){

var type=proto?
toString.call(lhs).slice(8,-1) + '.prototype':
lhs;


var propValue=methodCache[type + '.' + rhs] || lhs[rhs];


if(typeof propValue === 'function'){for(var _len=arguments.length,args=Array(_len > 3?_len - 3:0),_key=3;_key < _len;_key++) {args[_key - 3] = arguments[_key];}
return propValue.apply(lhs,args);}else
if(propValue){

return propValue;}


throw new Error('Polyfill ' + type + ' does not have implementation of ' + rhs);}__annotator(ES,{'module':'ES','line':93,'column':0,'endLine':111,'endColumn':1,'name':'ES'});


module.exports = ES;},{'module':'ES','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ES'}),null);
/** Path: html/js/sdk/sdk.babelHelpers.js */
/**
 * Copyright 2004-present Facebook. All Rights Reserved.
 *
 * @providesModule sdk.babelHelpers
 */__d('sdk.babelHelpers',['ES5FunctionPrototype','ES5Object','ES6Object'],__annotator(function $module_sdk_babelHelpers(global,require,requireDynamic,requireLazy,module,exports,ES5FunctionPrototype,ES5Object,ES6Object){if(require.__markCompiled)require.__markCompiled();











var babelHelpers={};
var hasOwn=Object.prototype.hasOwnProperty;




babelHelpers.inherits = __annotator(function(subClass,superClass){
ES6Object.assign(subClass,superClass);
subClass.prototype = ES5Object.create(superClass && superClass.prototype);
subClass.prototype.constructor = subClass;
subClass.__superConstructor__ = superClass;
return superClass;},{'module':'sdk.babelHelpers','line':23,'column':24,'endLine':29,'endColumn':1});





babelHelpers._extends = ES6Object.assign;




babelHelpers.objectWithoutProperties = __annotator(function(obj,keys){
var target={};
for(var i in obj) {
if(!hasOwn.call(obj,i) || keys.indexOf(i) >= 0){
continue;}

target[i] = obj[i];}

return target;},{'module':'sdk.babelHelpers','line':39,'column':39,'endLine':48,'endColumn':1});





babelHelpers.taggedTemplateLiteralLoose = __annotator(function(strings,raw){
strings.raw = raw;
return strings;},{'module':'sdk.babelHelpers','line':53,'column':42,'endLine':56,'endColumn':1});





babelHelpers.bind = ES5FunctionPrototype.bind;

module.exports = babelHelpers;},{'module':'sdk.babelHelpers','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_babelHelpers'}),null);      var ES = require('ES');      var babelHelpers = require('sdk.babelHelpers');      __d("UrlMapConfig",[],{"www":"www.facebook.com","m":"m.facebook.com","connect":"connect.facebook.net","business":"business.facebook.com","api_https":"api.facebook.com","api_read_https":"api-read.facebook.com","graph_https":"graph.facebook.com","fbcdn_http":"fbstatic-a.akamaihd.net","fbcdn_https":"fbstatic-a.akamaihd.net","cdn_http":"staticxx.facebook.com","cdn_https":"staticxx.facebook.com"});__d("JSSDKRuntimeConfig",[],{"locale":"en_US","rtl":false,"revision":"2138186"});__d("JSSDKConfig",[],{"bustCache":true,"tagCountLogRate":0.01,"errorHandling":{"rate":4},"usePluginPipe":true,"features":{"dialog_resize_refactor":true,"one_comment_controller":true,"allow_non_canvas_app_events":false,"event_subscriptions_log":{"rate":0.01,"value":10000},"should_force_single_dialog_instance":true,"js_sdk_force_status_on_load":true,"kill_fragment":true,"xfbml_profile_pic_server":true,"error_handling":{"rate":4},"e2e_ping_tracking":{"rate":1.0e-6},"getloginstatus_tracking":{"rate":0.001},"xd_timeout":{"rate":4,"value":30000},"use_bundle":false,"launch_payment_dialog_via_pac":{"rate":100},"plugin_tags_blacklist":["recommendations_bar","registration","activity","recommendations","facepile"],"should_log_response_error":true},"api":{"mode":"warn","whitelist":["AppEvents","AppEvents.EventNames","AppEvents.ParameterNames","AppEvents.activateApp","AppEvents.logEvent","AppEvents.logPurchase","Canvas","Canvas.Prefetcher","Canvas.Prefetcher.addStaticResource","Canvas.Prefetcher.setCollectionMode","Canvas.getPageInfo","Canvas.hideFlashElement","Canvas.scrollTo","Canvas.setAutoGrow","Canvas.setDoneLoading","Canvas.setSize","Canvas.setUrlHandler","Canvas.showFlashElement","Canvas.startTimer","Canvas.stopTimer","Event","Event.subscribe","Event.unsubscribe","Music.flashCallback","Music.init","Music.send","Payment","Payment.cancelFlow","Payment.continueFlow","Payment.init","Payment.lockForProcessing","Payment.parse","Payment.setSize","Payment.unlockForProcessing","ThirdPartyProvider","ThirdPartyProvider.init","ThirdPartyProvider.sendData","UA","UA.nativeApp","XFBML","XFBML.RecommendationsBar","XFBML.RecommendationsBar.markRead","XFBML.parse","addFriend","api","getAccessToken","getAuthResponse","getLoginStatus","getUserID","init","login","logout","publish","share","ui"]},"initSitevars":{"enableMobileComments":1,"iframePermissions":{"read_stream":false,"manage_mailbox":false,"manage_friendlists":false,"read_mailbox":false,"publish_checkins":true,"status_update":true,"photo_upload":true,"video_upload":true,"sms":false,"create_event":true,"rsvp_event":true,"offline_access":true,"email":true,"xmpp_login":false,"create_note":true,"share_item":true,"export_stream":false,"publish_stream":true,"publish_likes":true,"ads_management":false,"contact_email":true,"access_private_data":false,"read_insights":false,"read_requests":false,"read_friendlists":true,"manage_pages":false,"physical_login":false,"manage_groups":false,"read_deals":false}}});__d("JSSDKXDConfig",[],{"XdUrl":"\/connect\/xd_arbiter.php?version=42","XdBundleUrl":"\/connect\/xd_arbiter\/r\/BhI_5XzgAT8.js?version=42","Flash":{"path":"https:\/\/connect.facebook.net\/rsrc.php\/v1\/yW\/r\/yOZN1vHw3Z_.swf"},"useCdn":true});__d("JSSDKCssConfig",[],{"rules":".fb_hidden{position:absolute;top:-10000px;z-index:10001}.fb_reposition{overflow-x:hidden;position:relative}.fb_invisible{display:none}.fb_reset{background:none;border:0;border-spacing:0;color:#000;cursor:auto;direction:ltr;font-family:\"lucida grande\", tahoma, verdana, arial, sans-serif;font-size:11px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;line-height:1;margin:0;overflow:visible;padding:0;text-align:left;text-decoration:none;text-indent:0;text-shadow:none;text-transform:none;visibility:visible;white-space:normal;word-spacing:normal}.fb_reset>div{overflow:hidden}.fb_link img{border:none}\n.fb_dialog{background:rgba(82, 82, 82, .7);position:absolute;top:-10000px;z-index:10001}.fb_reset .fb_dialog_legacy{overflow:visible}.fb_dialog_advanced{padding:10px;-moz-border-radius:8px;-webkit-border-radius:8px;border-radius:8px}.fb_dialog_content{background:#fff;color:#333}.fb_dialog_close_icon{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yq\/r\/IE9JII6Z1Ys.png) no-repeat scroll 0 0 transparent;_background-image:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yL\/r\/s816eWC-2sl.gif);cursor:pointer;display:block;height:15px;position:absolute;right:18px;top:17px;width:15px}.fb_dialog_mobile .fb_dialog_close_icon{top:5px;left:5px;right:auto}.fb_dialog_padding{background-color:transparent;position:absolute;width:1px;z-index:-1}.fb_dialog_close_icon:hover{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yq\/r\/IE9JII6Z1Ys.png) no-repeat scroll 0 -15px transparent;_background-image:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yL\/r\/s816eWC-2sl.gif)}.fb_dialog_close_icon:active{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yq\/r\/IE9JII6Z1Ys.png) no-repeat scroll 0 -30px transparent;_background-image:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yL\/r\/s816eWC-2sl.gif)}.fb_dialog_loader{background-color:#f6f7f8;border:1px solid #606060;font-size:24px;padding:20px}.fb_dialog_top_left,.fb_dialog_top_right,.fb_dialog_bottom_left,.fb_dialog_bottom_right{height:10px;width:10px;overflow:hidden;position:absolute}.fb_dialog_top_left{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/ye\/r\/8YeTNIlTZjm.png) no-repeat 0 0;left:-10px;top:-10px}.fb_dialog_top_right{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/ye\/r\/8YeTNIlTZjm.png) no-repeat 0 -10px;right:-10px;top:-10px}.fb_dialog_bottom_left{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/ye\/r\/8YeTNIlTZjm.png) no-repeat 0 -20px;bottom:-10px;left:-10px}.fb_dialog_bottom_right{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/ye\/r\/8YeTNIlTZjm.png) no-repeat 0 -30px;right:-10px;bottom:-10px}.fb_dialog_vert_left,.fb_dialog_vert_right,.fb_dialog_horiz_top,.fb_dialog_horiz_bottom{position:absolute;background:#525252;filter:alpha(opacity=70);opacity:.7}.fb_dialog_vert_left,.fb_dialog_vert_right{width:10px;height:100\u0025}.fb_dialog_vert_left{margin-left:-10px}.fb_dialog_vert_right{right:0;margin-right:-10px}.fb_dialog_horiz_top,.fb_dialog_horiz_bottom{width:100\u0025;height:10px}.fb_dialog_horiz_top{margin-top:-10px}.fb_dialog_horiz_bottom{bottom:0;margin-bottom:-10px}.fb_dialog_iframe{line-height:0}.fb_dialog_content .dialog_title{background:#6d84b4;border:1px solid #3a5795;color:#fff;font-size:14px;font-weight:bold;margin:0}.fb_dialog_content .dialog_title>span{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yd\/r\/Cou7n-nqK52.gif) no-repeat 5px 50\u0025;float:left;padding:5px 0 7px 26px}body.fb_hidden{-webkit-transform:none;height:100\u0025;margin:0;overflow:visible;position:absolute;top:-10000px;left:0;width:100\u0025}.fb_dialog.fb_dialog_mobile.loading{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/ya\/r\/3rhSv5V8j3o.gif) white no-repeat 50\u0025 50\u0025;min-height:100\u0025;min-width:100\u0025;overflow:hidden;position:absolute;top:0;z-index:10001}.fb_dialog.fb_dialog_mobile.loading.centered{width:auto;height:auto;min-height:initial;min-width:initial;background:none}.fb_dialog.fb_dialog_mobile.loading.centered #fb_dialog_loader_spinner{width:100\u0025}.fb_dialog.fb_dialog_mobile.loading.centered .fb_dialog_content{background:none}.loading.centered #fb_dialog_loader_close{color:#fff;display:block;padding-top:20px;clear:both;font-size:18px}#fb-root #fb_dialog_ipad_overlay{background:rgba(0, 0, 0, .45);position:absolute;left:0;top:0;width:100\u0025;min-height:100\u0025;z-index:10000}#fb-root #fb_dialog_ipad_overlay.hidden{display:none}.fb_dialog.fb_dialog_mobile.loading iframe{visibility:hidden}.fb_dialog_content .dialog_header{-webkit-box-shadow:white 0 1px 1px -1px inset;background:-webkit-gradient(linear, 0\u0025 0\u0025, 0\u0025 100\u0025, from(#738ABA), to(#2C4987));border-bottom:1px solid;border-color:#1d4088;color:#fff;font:14px Helvetica, sans-serif;font-weight:bold;text-overflow:ellipsis;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0;vertical-align:middle;white-space:nowrap}.fb_dialog_content .dialog_header table{-webkit-font-smoothing:subpixel-antialiased;height:43px;width:100\u0025}.fb_dialog_content .dialog_header td.header_left{font-size:12px;padding-left:5px;vertical-align:middle;width:60px}.fb_dialog_content .dialog_header td.header_right{font-size:12px;padding-right:5px;vertical-align:middle;width:60px}.fb_dialog_content .touchable_button{background:-webkit-gradient(linear, 0\u0025 0\u0025, 0\u0025 100\u0025, from(#4966A6), color-stop(.5, #355492), to(#2A4887));border:1px solid #2f477a;-webkit-background-clip:padding-box;-webkit-border-radius:3px;-webkit-box-shadow:rgba(0, 0, 0, .117188) 0 1px 1px inset, rgba(255, 255, 255, .167969) 0 1px 0;display:inline-block;margin-top:3px;max-width:85px;line-height:18px;padding:4px 12px;position:relative}.fb_dialog_content .dialog_header .touchable_button input{border:none;background:none;color:#fff;font:12px Helvetica, sans-serif;font-weight:bold;margin:2px -12px;padding:2px 6px 3px 6px;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog_content .dialog_header .header_center{color:#fff;font-size:16px;font-weight:bold;line-height:18px;text-align:center;vertical-align:middle}.fb_dialog_content .dialog_content{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/y9\/r\/jKEcVPZFk-2.gif) no-repeat 50\u0025 50\u0025;border:1px solid #555;border-bottom:0;border-top:0;height:150px}.fb_dialog_content .dialog_footer{background:#f6f7f8;border:1px solid #555;border-top-color:#ccc;height:40px}#fb_dialog_loader_close{float:left}.fb_dialog.fb_dialog_mobile .fb_dialog_close_button{text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog.fb_dialog_mobile .fb_dialog_close_icon{visibility:hidden}#fb_dialog_loader_spinner{animation:rotateSpinner 1.2s linear infinite;background-color:transparent;background-image:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/yD\/r\/t-wz8gw1xG1.png);background-repeat:no-repeat;background-position:50\u0025 50\u0025;height:24px;width:24px}\u0040keyframes rotateSpinner{0\u0025{transform:rotate(0deg)}100\u0025{transform:rotate(360deg)}}\n.fb_iframe_widget{display:inline-block;position:relative}.fb_iframe_widget span{display:inline-block;position:relative;text-align:justify}.fb_iframe_widget iframe{position:absolute}.fb_iframe_widget_fluid_desktop,.fb_iframe_widget_fluid_desktop span,.fb_iframe_widget_fluid_desktop iframe{max-width:100\u0025}.fb_iframe_widget_fluid_desktop iframe{min-width:220px;position:relative}.fb_iframe_widget_lift{z-index:1}.fb_hide_iframes iframe{position:relative;left:-10000px}.fb_iframe_widget_loader{position:relative;display:inline-block}.fb_iframe_widget_fluid{display:inline}.fb_iframe_widget_fluid span{width:100\u0025}.fb_iframe_widget_loader iframe{min-height:32px;z-index:2;zoom:1}.fb_iframe_widget_loader .FB_Loader{background:url(https:\/\/fbstatic-a.akamaihd.net\/rsrc.php\/v2\/y9\/r\/jKEcVPZFk-2.gif) no-repeat;height:32px;width:32px;margin-left:-16px;position:absolute;left:50\u0025;z-index:4}","components":["css:fb.css.base","css:fb.css.dialog","css:fb.css.iframewidget"]});__d("ApiClientConfig",[],{"FlashRequest":{"swfUrl":"https:\/\/connect.facebook.net\/rsrc.php\/v1\/yd\/r\/mxzow1Sdmxr.swf"}});__d("JSSDKCanvasPrefetcherConfig",[],{"blacklist":[144959615576466],"sampleRate":500});__d("JSSDKPluginPipeConfig",[],{"threshold":0,"enabledApps":{"209753825810663":1,"187288694643718":1}});
__d("DOMWrapper",[],__annotator(function $module_DOMWrapper(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var rootElement,
windowRef;



var DOMWrapper={
setRoot:__annotator(function(root){return __bodyWrapper(this,arguments,function(){
rootElement = root;},{params:[[root,"?HTMLElement","root"]]});},{"module":"DOMWrapper","line":20,"column":11,"endLine":22,"endColumn":3},{params:["?HTMLElement"]}),

getRoot:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return rootElement || document.body;},{returns:"HTMLElement"});},{"module":"DOMWrapper","line":23,"column":11,"endLine":25,"endColumn":3},{returns:"HTMLElement"}),

setWindow:__annotator(function(win){
windowRef = win;},{"module":"DOMWrapper","line":26,"column":13,"endLine":28,"endColumn":3}),

getWindow:__annotator(function(){
return windowRef || self;},{"module":"DOMWrapper","line":29,"column":13,"endLine":31,"endColumn":3})};



module.exports = DOMWrapper;},{"module":"DOMWrapper","line":0,"column":0,"endLine":0,"endColumn":0,"name":"$module_DOMWrapper"}),null);

__d('dotAccess',[],__annotator(function $module_dotAccess(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function dotAccess(head,path,create){
var stack=path.split('.');
do {
var key=stack.shift();
head = head[key] || create && (head[key] = {});}while(
stack.length && head);
return head;}__annotator(dotAccess,{'module':'dotAccess','line':33,'column':0,'endLine':40,'endColumn':1,'name':'dotAccess'});


module.exports = dotAccess;},{'module':'dotAccess','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_dotAccess'}),null);

__d('guid',[],__annotator(function $module_guid(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();



function guid(){
return 'f' + (Math.random() * (1 << 30)).toString(16).replace('.','');}__annotator(guid,{'module':'guid','line':27,'column':0,'endLine':29,'endColumn':1,'name':'guid'});


module.exports = guid;},{'module':'guid','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_guid'}),null);

__d('wrapFunction',[],__annotator(function $module_wrapFunction(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var wrappers={};
function wrapFunction(fn,type,source){return __bodyWrapper(this,arguments,function()
{
type = type || 'default';

return __annotator(function(){
var callee=type in wrappers?
wrappers[type](fn,source):
fn;

return callee.apply(this,arguments);},{'module':'wrapFunction','line':34,'column':9,'endLine':40,'endColumn':3});},{params:[[fn,'function','fn'],[type,'?string','type'],[source,'?string','source']],returns:'function'});}__annotator(wrapFunction,{'module':'wrapFunction','line':30,'column':0,'endLine':41,'endColumn':1,'name':'wrapFunction'},{params:['function','?string','?string'],returns:'function'});



wrapFunction.setWrapper = __annotator(function(fn,type){return __bodyWrapper(this,arguments,function(){
type = type || 'default';
wrappers[type] = fn;},{params:[[fn,'function','fn'],[type,'?string','type']]});},{'module':'wrapFunction','line':43,'column':26,'endLine':46,'endColumn':1},{params:['function','?string']});


module.exports = wrapFunction;},{'module':'wrapFunction','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_wrapFunction'}),null);

__d('GlobalCallback',['DOMWrapper','dotAccess','guid','wrapFunction'],__annotator(function $module_GlobalCallback(global,require,requireDynamic,requireLazy,module,exports,DOMWrapper,dotAccess,guid,wrapFunction){if(require.__markCompiled)require.__markCompiled();








var rootObject;
var callbackPrefix;

var GlobalCallback={

setPrefix:__annotator(function(prefix){return __bodyWrapper(this,arguments,function(){
rootObject = dotAccess(DOMWrapper.getWindow(),prefix,true);
callbackPrefix = prefix;},{params:[[prefix,'string','prefix']]});},{'module':'GlobalCallback','line':37,'column':13,'endLine':40,'endColumn':3},{params:['string']}),


create:__annotator(function(fn,description){return __bodyWrapper(this,arguments,function(){
if(!rootObject){


this.setPrefix('__globalCallbacks');}

var id=guid();
rootObject[id] = wrapFunction(fn,'entry',description || 'GlobalCallback');

return callbackPrefix + '.' + id;},{params:[[fn,'function','fn'],[description,'?string','description']],returns:'string'});},{'module':'GlobalCallback','line':42,'column':10,'endLine':52,'endColumn':3},{params:['function','?string'],returns:'string'}),


remove:__annotator(function(name){return __bodyWrapper(this,arguments,function(){
var id=name.substring(callbackPrefix.length + 1);
delete rootObject[id];},{params:[[name,'string','name']]});},{'module':'GlobalCallback','line':54,'column':10,'endLine':57,'endColumn':3},{params:['string']})};




module.exports = GlobalCallback;},{'module':'GlobalCallback','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_GlobalCallback'}),null);

__d("sprintf",[],__annotator(function $module_sprintf(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();










function sprintf(format){for(var _len=arguments.length,args=Array(_len > 1?_len - 1:0),_key=1;_key < _len;_key++) {args[_key - 1] = arguments[_key];}return __bodyWrapper(this,arguments,function(){
var index=0;
return format.replace(/%s/g,__annotator(function(match){return args[index++];},{"module":"sprintf","line":32,"column":31,"endLine":32,"endColumn":53}));},{params:[[format,"string","format"]],returns:"string"});}__annotator(sprintf,{"module":"sprintf","line":30,"column":0,"endLine":33,"endColumn":1,"name":"sprintf"},{params:["string"],returns:"string"});


module.exports = sprintf;},{"module":"sprintf","line":0,"column":0,"endLine":0,"endColumn":0,"name":"$module_sprintf"}),null);

__d('Log',['sprintf'],__annotator(function $module_Log(global,require,requireDynamic,requireLazy,module,exports,sprintf){if(require.__markCompiled)require.__markCompiled();



var Level={
DEBUG:3,
INFO:2,
WARNING:1,
ERROR:0};


function log(name,level){return __bodyWrapper(this,arguments,function(){
var args=Array.prototype.slice.call(arguments,2);
var msg=sprintf.apply(null,args);
var console=window.console;
if(console && Log.level >= level){
console[name in console?name:'log'](msg);}},{params:[[name,'string','name'],[level,'number','level']]});}__annotator(log,{'module':'Log','line':38,'column':0,'endLine':45,'endColumn':1,'name':'log'},{params:['string','number']});



var Log={



level:__DEV__?3:-1,






Level:Level,








debug:ES(log,'bind',true,null,'debug',Level.DEBUG),
info:ES(log,'bind',true,null,'info',Level.INFO),
warn:ES(log,'bind',true,null,'warn',Level.WARNING),
error:ES(log,'bind',true,null,'error',Level.ERROR)};

module.exports = Log;},{'module':'Log','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_Log'}),null);

__d("ObservableMixin",[],__annotator(function $module_ObservableMixin(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function ObservableMixin(){
this.__observableEvents = {};}__annotator(ObservableMixin,{"module":"ObservableMixin","line":22,"column":0,"endLine":24,"endColumn":1,"name":"ObservableMixin"});


ObservableMixin.prototype = {










inform:__annotator(function(what){return __bodyWrapper(this,arguments,function(){

var args=Array.prototype.slice.call(arguments,1);
var list=Array.prototype.slice.call(this.getSubscribers(what));
for(var i=0;i < list.length;i++) {
if(list[i] === null)continue;
if(__DEV__){
list[i].apply(this,args);}else
{
try{
list[i].apply(this,args);}
catch(e) {


setTimeout(__annotator(function(){throw e;},{"module":"ObservableMixin","line":51,"column":21,"endLine":51,"endColumn":44}),0);}}}



return this;},{params:[[what,"string","what"]]});},{"module":"ObservableMixin","line":37,"column":10,"endLine":56,"endColumn":3},{params:["string"]}),








getSubscribers:__annotator(function(toWhat){return __bodyWrapper(this,arguments,function(){

return this.__observableEvents[toWhat] || (
this.__observableEvents[toWhat] = []);},{params:[[toWhat,"string","toWhat"]],returns:"array"});},{"module":"ObservableMixin","line":64,"column":18,"endLine":68,"endColumn":3},{params:["string"],returns:"array"}),







clearSubscribers:__annotator(function(toWhat){return __bodyWrapper(this,arguments,function(){

if(toWhat){
this.__observableEvents[toWhat] = [];}

return this;},{params:[[toWhat,"string","toWhat"]]});},{"module":"ObservableMixin","line":75,"column":20,"endLine":81,"endColumn":3},{params:["string"]}),






clearAllSubscribers:__annotator(function(){
this.__observableEvents = {};
return this;},{"module":"ObservableMixin","line":87,"column":23,"endLine":90,"endColumn":3}),









subscribe:__annotator(function(toWhat,withWhat){return __bodyWrapper(this,arguments,function(){

var list=this.getSubscribers(toWhat);
list.push(withWhat);
return this;},{params:[[toWhat,"string","toWhat"],[withWhat,"function","withWhat"]]});},{"module":"ObservableMixin","line":99,"column":13,"endLine":104,"endColumn":3},{params:["string","function"]}),









unsubscribe:__annotator(function(toWhat,withWhat){return __bodyWrapper(this,arguments,function(){

var list=this.getSubscribers(toWhat);
for(var i=0;i < list.length;i++) {
if(list[i] === withWhat){
list.splice(i,1);
break;}}


return this;},{params:[[toWhat,"string","toWhat"],[withWhat,"function","withWhat"]]});},{"module":"ObservableMixin","line":113,"column":15,"endLine":123,"endColumn":3},{params:["string","function"]}),










monitor:__annotator(function(toWhat,withWhat){return __bodyWrapper(this,arguments,function(){
if(!withWhat()){
var monitor=ES(__annotator(function(value){
if(withWhat.apply(withWhat,arguments)){
this.unsubscribe(toWhat,monitor);}},{"module":"ObservableMixin","line":135,"column":20,"endLine":139,"endColumn":7}),"bind",true,

this);
this.subscribe(toWhat,monitor);}

return this;},{params:[[toWhat,"string","toWhat"],[withWhat,"function","withWhat"]]});},{"module":"ObservableMixin","line":133,"column":11,"endLine":143,"endColumn":3},{params:["string","function"]})};





module.exports = ObservableMixin;},{"module":"ObservableMixin","line":0,"column":0,"endLine":0,"endColumn":0,"name":"$module_ObservableMixin"}),null);

__d('UrlMap',['UrlMapConfig'],__annotator(function $module_UrlMap(global,require,requireDynamic,requireLazy,module,exports,UrlMapConfig){if(require.__markCompiled)require.__markCompiled();



var UrlMap={








resolve:__annotator(function(key,https){return __bodyWrapper(this,arguments,function(){
var protocol=typeof https == 'undefined'?
location.protocol.replace(':',''):
https?'https':'http';


if(key in UrlMapConfig){
return protocol + '://' + UrlMapConfig[key];}



if(typeof https == 'undefined' && key + '_' + protocol in UrlMapConfig){
return protocol + '://' + UrlMapConfig[key + '_' + protocol];}



if(https !== true && key + '_http' in UrlMapConfig){
return 'http://' + UrlMapConfig[key + '_http'];}



if(https !== false && key + '_https' in UrlMapConfig){
return 'https://' + UrlMapConfig[key + '_https'];}},{params:[[key,'string','key'],[https,'?boolean','https']],returns:'string'});},{'module':'UrlMap','line':28,'column':11,'endLine':52,'endColumn':3},{params:['string','?boolean'],returns:'string'})};




module.exports = UrlMap;},{'module':'UrlMap','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_UrlMap'}),null);

__d('QueryString',[],__annotator(function $module_QueryString(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();






function encode(bag){return __bodyWrapper(this,arguments,function(){
var pairs=[];
ES(ES('Object','keys',false,bag).sort(),'forEach',true,__annotator(function(key){
var value=bag[key];

if(typeof value === 'undefined'){
return;}


if(value === null){
pairs.push(key);
return;}


pairs.push(encodeURIComponent(key) +
'=' +
encodeURIComponent(value));},{'module':'QueryString','line':31,'column':34,'endLine':46,'endColumn':3}));

return pairs.join('&');},{params:[[bag,'object','bag']],returns:'string'});}__annotator(encode,{'module':'QueryString','line':29,'column':0,'endLine':48,'endColumn':1,'name':'encode'},{params:['object'],returns:'string'});





function decode(str,strict){return __bodyWrapper(this,arguments,function(){
var data={};
if(str === ''){
return data;}


var pairs=str.split('&');
for(var i=0;i < pairs.length;i++) {
var pair=pairs[i].split('=',2);
var key=decodeURIComponent(pair[0]);
if(strict && data.hasOwnProperty(key)){
throw new URIError('Duplicate key: ' + key);}

data[key] = pair.length === 2?
decodeURIComponent(pair[1]):
null;}

return data;},{params:[[str,'string','str'],[strict,'?boolean','strict']],returns:'object'});}__annotator(decode,{'module':'QueryString','line':53,'column':0,'endLine':71,'endColumn':1,'name':'decode'},{params:['string','?boolean'],returns:'object'});







function appendToUrl(url,params){return __bodyWrapper(this,arguments,function(){
return url + (
ES(url,'indexOf',true,'?') !== -1?'&':'?') + (
typeof params === 'string'?
params:
QueryString.encode(params));},{params:[[url,'string','url']],returns:'string'});}__annotator(appendToUrl,{'module':'QueryString','line':78,'column':0,'endLine':84,'endColumn':1,'name':'appendToUrl'},{params:['string'],returns:'string'});


var QueryString={
encode:encode,
decode:decode,
appendToUrl:appendToUrl};


module.exports = QueryString;},{'module':'QueryString','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_QueryString'}),null);

__d("ManagedError",[],__annotator(function $module_ManagedError(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function ManagedError(message,innerError){
Error.prototype.constructor.call(this,message);
this.message = message;
this.innerError = innerError;}__annotator(ManagedError,{"module":"ManagedError","line":30,"column":0,"endLine":34,"endColumn":1,"name":"ManagedError"});

ManagedError.prototype = new Error();
ManagedError.prototype.constructor = ManagedError;

module.exports = ManagedError;},{"module":"ManagedError","line":0,"column":0,"endLine":0,"endColumn":0,"name":"$module_ManagedError"}),null);

__d('AssertionError',['ManagedError'],__annotator(function $module_AssertionError(global,require,requireDynamic,requireLazy,module,exports,ManagedError){if(require.__markCompiled)require.__markCompiled();



function AssertionError(message){
ManagedError.prototype.constructor.apply(this,arguments);}__annotator(AssertionError,{'module':'AssertionError','line':12,'column':0,'endLine':14,'endColumn':1,'name':'AssertionError'});

AssertionError.prototype = new ManagedError();
AssertionError.prototype.constructor = AssertionError;

module.exports = AssertionError;},{'module':'AssertionError','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_AssertionError'}),null);

__d('Assert',['AssertionError','sprintf'],__annotator(function $module_Assert(global,require,requireDynamic,requireLazy,module,exports,AssertionError,sprintf){if(require.__markCompiled)require.__markCompiled();













function assert(expression,message){return __bodyWrapper(this,arguments,function(){
if(typeof expression !== 'boolean' || !expression){
throw new AssertionError(message);}

return expression;},{params:[[expression,'boolean','expression'],[message,'?string','message']],returns:'boolean'});}__annotator(assert,{'module':'Assert','line':23,'column':0,'endLine':28,'endColumn':1,'name':'assert'},{params:['boolean','?string'],returns:'boolean'});











function assertType(type,expression,message){return __bodyWrapper(this,arguments,function(){
var actualType;

if(expression === undefined){
actualType = 'undefined';}else
if(expression === null){
actualType = 'null';}else
{
var className=Object.prototype.toString.call(expression);
actualType = /\s(\w*)/.exec(className)[1].toLowerCase();}


assert(
ES(type,'indexOf',true,actualType) !== -1,
message || sprintf('Expression is of type %s, not %s',actualType,type));

return expression;},{params:[[type,'string','type'],[message,'?string','message']]});}__annotator(assertType,{'module':'Assert','line':39,'column':0,'endLine':56,'endColumn':1,'name':'assertType'},{params:['string','?string']});











function assertInstanceOf(type,expression,message){return __bodyWrapper(this,arguments,function(){
assert(
expression instanceof type,
message || 'Expression not instance of type');

return expression;},{params:[[type,'function','type'],[message,'?string','message']]});}__annotator(assertInstanceOf,{'module':'Assert','line':67,'column':0,'endLine':73,'endColumn':1,'name':'assertInstanceOf'},{params:['function','?string']});


function define(type,test){return __bodyWrapper(this,arguments,function(){
Assert['is' + type] = test;
Assert['maybe' + type] = __annotator(function(expression,message){

if(expression != null){
test(expression,message);}},{'module':'Assert','line':77,'column':27,'endLine':82,'endColumn':3});},{params:[[type,'string','type'],[test,'function','test']]});}__annotator(define,{'module':'Assert','line':75,'column':0,'endLine':83,'endColumn':1,'name':'define'},{params:['string','function']});




var Assert={
isInstanceOf:assertInstanceOf,
isTrue:assert,
isTruthy:__annotator(function(expression,message){return __bodyWrapper(this,arguments,function(){
return assert(!!expression,message);},{params:[[message,'?string','message']],returns:'boolean'});},{'module':'Assert','line':88,'column':16,'endLine':90,'endColumn':3},{params:['?string'],returns:'boolean'}),

type:assertType,
define:__annotator(function(type,fn){return __bodyWrapper(this,arguments,function(){
type = type.substring(0,1).toUpperCase() +
type.substring(1).toLowerCase();

define(type,__annotator(function(expression,message){
assert(fn(expression),message);},{'module':'Assert','line':96,'column':17,'endLine':98,'endColumn':5}));},{params:[[type,'string','type'],[fn,'function','fn']]});},{'module':'Assert','line':92,'column':16,'endLine':99,'endColumn':3},{params:['string','function']})};





ES(['Array',
'Boolean',
'Date',
'Function',
'Null',
'Number',
'Object',
'Regexp',
'String',
'Undefined'],'forEach',true,__annotator(function(type){return __bodyWrapper(this,arguments,function(){
define(type,ES(assertType,'bind',true,null,type.toLowerCase()));},{params:[[type,'string','type']]});},{'module':'Assert','line':112,'column':22,'endLine':114,'endColumn':2},{params:['string']}));


module.exports = Assert;},{'module':'Assert','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_Assert'}),null);

__d('Type',['Assert'],__annotator(function $module_Type(global,require,requireDynamic,requireLazy,module,exports,Assert){if(require.__markCompiled)require.__markCompiled();






function Type(){
var mixins=this.__mixins;
if(mixins){
for(var i=0;i < mixins.length;i++) {
mixins[i].apply(this,arguments);}}}__annotator(Type,{'module':'Type','line':75,'column':0,'endLine':82,'endColumn':1,'name':'Type'});














function instanceOf(constructor,which){return __bodyWrapper(this,arguments,function(){


if(which instanceof constructor){
return true;}



if(which instanceof Type){
for(var i=0;i < which.__mixins.length;i++) {
if(which.__mixins[i] == constructor){
return true;}}}




return false;},{params:[[constructor,'function','constructor']],returns:'boolean'});}__annotator(instanceOf,{'module':'Type','line':94,'column':0,'endLine':111,'endColumn':1,'name':'instanceOf'},{params:['function'],returns:'boolean'});










function mixin(to,from){return __bodyWrapper(this,arguments,function(){
var prototype=to.prototype;

if(!ES('Array','isArray',false,from)){
from = [from];}


for(var i=0;i < from.length;i++) {
var mixinFrom=from[i];

if(typeof mixinFrom == 'function'){
prototype.__mixins.push(mixinFrom);
mixinFrom = mixinFrom.prototype;}


ES(ES('Object','keys',false,mixinFrom),'forEach',true,__annotator(function(key){
prototype[key] = mixinFrom[key];},{'module':'Type','line':136,'column':35,'endLine':138,'endColumn':5}));}},{params:[[to,'function','to']]});}__annotator(mixin,{'module':'Type','line':121,'column':0,'endLine':140,'endColumn':1,'name':'mixin'},{params:['function']});


















function extend(from,prototype,mixins){return __bodyWrapper(this,arguments,function()
{
var constructor=prototype && prototype.hasOwnProperty('constructor')?
prototype.constructor:__annotator(
function(){this.parent.apply(this,arguments);},{'module':'Type','line':160,'column':6,'endLine':160,'endColumn':54});

Assert.isFunction(constructor);


if(from && from.prototype instanceof Type === false){
throw new Error('parent type does not inherit from Type');}

from = from || Type;


function F(){}__annotator(F,{'module':'Type','line':171,'column':2,'endLine':171,'endColumn':17,'name':'F'});
F.prototype = from.prototype;
constructor.prototype = new F();

if(prototype){
ES('Object','assign',false,constructor.prototype,prototype);}



constructor.prototype.constructor = constructor;

constructor.parent = from;



constructor.prototype.__mixins = from.prototype.__mixins?
Array.prototype.slice.call(from.prototype.__mixins):
[];


if(mixins){
mixin(constructor,mixins);}



constructor.prototype.parent = __annotator(function(){
this.parent = from.prototype.parent;
from.apply(this,arguments);},{'module':'Type','line':196,'column':33,'endLine':199,'endColumn':3});



constructor.prototype.parentCall = __annotator(function(method){return __bodyWrapper(this,arguments,function(){
return from.prototype[method].apply(this,
Array.prototype.slice.call(arguments,1));},{params:[[method,'string','method']]});},{'module':'Type','line':202,'column':37,'endLine':205,'endColumn':3},{params:['string']});


constructor.extend = __annotator(function(prototype,mixins){return __bodyWrapper(this,arguments,function(){
return extend(this,prototype,mixins);},{params:[[prototype,'?object','prototype']]});},{'module':'Type','line':207,'column':23,'endLine':209,'endColumn':3},{params:['?object']});

return constructor;},{params:[[from,'?function','from'],[prototype,'?object','prototype']],returns:'function'});}__annotator(extend,{'module':'Type','line':156,'column':0,'endLine':211,'endColumn':1,'name':'extend'},{params:['?function','?object'],returns:'function'});


ES('Object','assign',false,Type.prototype,{
instanceOf:__annotator(function(type){return __bodyWrapper(this,arguments,function(){
return instanceOf(type,this);},{params:[[type,'function','type']],returns:'boolean'});},{'module':'Type','line':214,'column':14,'endLine':216,'endColumn':3},{params:['function'],returns:'boolean'})});



ES('Object','assign',false,Type,{
extend:__annotator(function(prototype,mixins){return __bodyWrapper(this,arguments,function(){
return typeof prototype === 'function'?
extend.apply(null,arguments):
extend(null,prototype,mixins);},{returns:'function'});},{'module':'Type','line':220,'column':10,'endLine':224,'endColumn':3},{returns:'function'}),

instanceOf:instanceOf});


module.exports = Type;},{'module':'Type','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_Type'}),null);

__d('sdk.Model',['Type','ObservableMixin'],__annotator(function $module_sdk_Model(global,require,requireDynamic,requireLazy,module,exports,Type,ObservableMixin){if(require.__markCompiled)require.__markCompiled();




var Model=Type.extend({
constructor:__annotator(function(properties){return __bodyWrapper(this,arguments,function(){
this.parent();


var propContainer={};
var model=this;

ES(ES('Object','keys',false,properties),'forEach',true,__annotator(function(name){return __bodyWrapper(this,arguments,function(){

propContainer[name] = properties[name];


model['set' + name] = __annotator(function(value){
if(value === propContainer[name]){
return this;}

propContainer[name] = value;
model.inform(name + '.change',value);
return model;},{'module':'sdk.Model','line':48,'column':28,'endLine':55,'endColumn':7});



model['get' + name] = __annotator(function(){
return propContainer[name];},{'module':'sdk.Model','line':58,'column':28,'endLine':60,'endColumn':7});},{params:[[name,'string','name']]});},{'module':'sdk.Model','line':43,'column':36,'endLine':61,'endColumn':5},{params:['string']}));},{params:[[properties,'object','properties']]});},{'module':'sdk.Model','line':36,'column':15,'endLine':62,'endColumn':3},{params:['object']})},



ObservableMixin);

module.exports = Model;},{'module':'sdk.Model','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Model'}),null);

__d('sdk.Runtime',['sdk.Model','JSSDKRuntimeConfig'],__annotator(function $module_sdk_Runtime(global,require,requireDynamic,requireLazy,module,exports,Model,RuntimeConfig){if(require.__markCompiled)require.__markCompiled();





var ENVIRONMENTS={
UNKNOWN:0,
PAGETAB:1,
CANVAS:2,
PLATFORM:4};


var Runtime=new Model({
AccessToken:'',
ClientID:'',
CookieUserID:'',
Environment:ENVIRONMENTS.UNKNOWN,
Initialized:false,
IsVersioned:false,
KidDirectedSite:undefined,
Locale:RuntimeConfig.locale,
LoggedIntoFacebook:undefined,
LoginStatus:undefined,
Revision:RuntimeConfig.revision,
Rtl:RuntimeConfig.rtl,
Scope:undefined,
Secure:undefined,
UseCookie:false,
UserID:'',
Version:undefined});


ES('Object','assign',false,Runtime,{

ENVIRONMENTS:ENVIRONMENTS,

isEnvironment:__annotator(function(target){return __bodyWrapper(this,arguments,function(){
var environment=this.getEnvironment();
return (target | environment) === environment;},{params:[[target,'number','target']],returns:'boolean'});},{'module':'sdk.Runtime','line':46,'column':17,'endLine':49,'endColumn':3},{params:['number'],returns:'boolean'}),


isCanvasEnvironment:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return this.isEnvironment(ENVIRONMENTS.CANVAS) ||
this.isEnvironment(ENVIRONMENTS.PAGETAB);},{returns:'boolean'});},{'module':'sdk.Runtime','line':51,'column':23,'endLine':54,'endColumn':3},{returns:'boolean'})});



__annotator(function(){
var environment=/app_runner/.test(window.name)?
ENVIRONMENTS.PAGETAB:
/iframe_canvas/.test(window.name)?
ENVIRONMENTS.CANVAS:
ENVIRONMENTS.UNKNOWN;


if((environment | ENVIRONMENTS.PAGETAB) === environment){
environment = environment | ENVIRONMENTS.CANVAS;}

Runtime.setEnvironment(environment);},{'module':'sdk.Runtime','line':57,'column':1,'endLine':69,'endColumn':1})();


module.exports = Runtime;},{'module':'sdk.Runtime','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Runtime'}),null);

__d('sdk.Cookie',['QueryString','sdk.Runtime'],__annotator(function $module_sdk_Cookie(global,require,requireDynamic,requireLazy,module,exports,QueryString,Runtime){if(require.__markCompiled)require.__markCompiled();






var domain=null;








function setRaw(prefix,val,ts){return __bodyWrapper(this,arguments,function(){
prefix = prefix + Runtime.getClientID();

var useDomain=domain && domain !== '.';

if(useDomain){

document.cookie = prefix + '=; expires=Wed, 04 Feb 2004 08:00:00 GMT;';

document.cookie = prefix + '=; expires=Wed, 04 Feb 2004 08:00:00 GMT;' +
'domain=' + location.hostname + ';';}


var expires=new Date(ts).toGMTString();
document.cookie = prefix + '=' + val + (
val && ts === 0?'':'; expires=' + expires) +
'; path=/' + (
useDomain?'; domain=' + domain:'');},{params:[[prefix,'string','prefix'],[val,'string','val'],[ts,'number','ts']]});}__annotator(setRaw,{'module':'sdk.Cookie','line':28,'column':0,'endLine':46,'endColumn':1,'name':'setRaw'},{params:['string','string','number']});


function getRaw(prefix){return __bodyWrapper(this,arguments,function(){
prefix = prefix + Runtime.getClientID();
var regExp=new RegExp('\\b' + prefix + '=([^;]*)\\b');
return regExp.test(document.cookie)?
RegExp.$1:
null;},{params:[[prefix,'string','prefix']],returns:'?string'});}__annotator(getRaw,{'module':'sdk.Cookie','line':48,'column':0,'endLine':54,'endColumn':1,'name':'getRaw'},{params:['string'],returns:'?string'});


var Cookie={
setDomain:__annotator(function(val){return __bodyWrapper(this,arguments,function(){
domain = val;

var meta=QueryString.encode({
base_domain:domain && domain !== '.'?domain:''});

var expiration=new Date();
expiration.setFullYear(expiration.getFullYear() + 1);
setRaw('fbm_',meta,expiration.getTime());},{params:[[val,'?string','val']]});},{'module':'sdk.Cookie','line':57,'column':13,'endLine':66,'endColumn':3},{params:['?string']}),


getDomain:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return domain;},{returns:'?string'});},{'module':'sdk.Cookie','line':68,'column':13,'endLine':70,'endColumn':3},{returns:'?string'}),







loadMeta:__annotator(function(){return __bodyWrapper(this,arguments,function(){
var cookie=getRaw('fbm_');
if(cookie){

var meta=QueryString.decode(cookie);
if(!domain){

domain = meta.base_domain;}

return meta;}},{returns:'?object'});},{'module':'sdk.Cookie','line':77,'column':12,'endLine':88,'endColumn':3},{returns:'?object'}),








loadSignedRequest:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return getRaw('fbsr_');},{returns:'?string'});},{'module':'sdk.Cookie','line':95,'column':21,'endLine':97,'endColumn':3},{returns:'?string'}),











setSignedRequestCookie:__annotator(function(signedRequest,
expiration){return __bodyWrapper(this,arguments,function(){
if(!signedRequest){
throw new Error('Value passed to Cookie.setSignedRequestCookie ' +
'was empty.');}

setRaw('fbsr_',signedRequest,expiration);},{params:[[signedRequest,'string','signedRequest'],[expiration,'number','expiration']]});},{'module':'sdk.Cookie','line':108,'column':26,'endLine':115,'endColumn':3},{params:['string','number']}),






clearSignedRequestCookie:__annotator(function(){
setRaw('fbsr_','',0);},{'module':'sdk.Cookie','line':121,'column':28,'endLine':123,'endColumn':3}),


setRaw:setRaw,

getRaw:getRaw};


module.exports = Cookie;},{'module':'sdk.Cookie','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Cookie'}),null);

__d('Miny',[],__annotator(function $module_Miny(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var MAGIC='Miny1';
var LO='wxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_'.split('');

var Miny={

encode:__annotator(function(s){
if(/^$|[~\\]|__proto__/.test(s)){
return s;}



var parts=s.match(/\w+|\W+/g);

var i;


var dict=ES('Object','create',false,null);
for(i = 0;i < parts.length;i++) {
dict[parts[i]] = (dict[parts[i]] || 0) + 1;}




var keys=ES('Object','keys',false,dict);
keys.sort(__annotator(function(a,b){return dict[b] - dict[a];},{'module':'Miny','line':35,'column':14,'endLine':35,'endColumn':41}));


for(i = 0;i < keys.length;i++) {
var n=(i - i % 32) / 32;
dict[keys[i]] = n?n.toString(32) + LO[i % 32]:LO[i % 32];}



var codes='';
for(i = 0;i < parts.length;i++) {
codes += dict[parts[i]];}


keys.unshift(MAGIC,keys.length);
keys.push(codes);
return keys.join('~');},{'module':'Miny','line':16,'column':8,'endLine':52,'endColumn':3})};



module.exports = Miny;},{'module':'Miny','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_Miny'}),null);

__d('sdk.UA',[],__annotator(function $module_sdk_UA(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var uas=navigator.userAgent;


var devices={
iphone:/\b(iPhone|iP[ao]d)/.test(uas),
ipad:/\b(iP[ao]d)/.test(uas),
android:/Android/i.test(uas),
nativeApp:/FBAN\/\w+;/i.test(uas)};

var mobile=/Mobile/i.test(uas);


var versions={
ie:'',
firefox:'',
chrome:'',
webkit:'',
osx:''};

var agent=
/(?:MSIE.(\d+\.\d+))|(?:(?:Firefox|GranParadiso|Iceweasel).(\d+\.\d+))|(?:AppleWebKit.(\d+(?:\.\d+)?))|(?:Trident\/\d+\.\d+.*rv:(\d+\.\d+))/.
exec(uas);
if(agent){
versions.ie = agent[1]?
parseFloat(agent[1]):
agent[4]?
parseFloat(agent[4]):
'';

versions.firefox = agent[2] || '';
versions.webkit = agent[3] || '';
if(agent[3]){



var chromeAgent=/(?:Chrome\/(\d+\.\d+))/.exec(uas);
versions.chrome = chromeAgent?chromeAgent[1]:'';}}




var mac=/(?:Mac OS X (\d+(?:[._]\d+)?))/.exec(uas);
if(mac){
versions.osx = mac[1];}


function getVersionParts(version){return __bodyWrapper(this,arguments,function(){
return ES(version.split('.'),'map',true,__annotator(function(v){return parseFloat(v);},{'module':'sdk.UA','line':92,'column':32,'endLine':92,'endColumn':50}));},{params:[[version,'string','version']],returns:'array'});}__annotator(getVersionParts,{'module':'sdk.UA','line':91,'column':0,'endLine':93,'endColumn':1,'name':'getVersionParts'},{params:['string'],returns:'array'});


var UA={};

ES(ES('Object','keys',false,versions),'map',true,__annotator(function(key){



UA[key] = __annotator(function(){return parseFloat(versions[key]);},{'module':'sdk.UA','line':101,'column':12,'endLine':101,'endColumn':43});



UA[key].getVersionParts = __annotator(function(){return getVersionParts(versions[key]);},{'module':'sdk.UA','line':105,'column':28,'endLine':105,'endColumn':64});},{'module':'sdk.UA','line':97,'column':26,'endLine':106,'endColumn':1}));


ES(ES('Object','keys',false,devices),'map',true,__annotator(function(key){



UA[key] = __annotator(function(){return devices[key];},{'module':'sdk.UA','line':112,'column':12,'endLine':112,'endColumn':30});},{'module':'sdk.UA','line':108,'column':25,'endLine':113,'endColumn':1}));





UA.mobile = __annotator(function(){return devices.iphone || devices.ipad || devices.android || mobile;},{'module':'sdk.UA','line':118,'column':12,'endLine':118,'endColumn':77});


module.exports = UA;},{'module':'sdk.UA','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_UA'}),null);

__d('getBlankIframeSrc',['sdk.UA'],__annotator(function $module_getBlankIframeSrc(global,require,requireDynamic,requireLazy,module,exports,UA){if(require.__markCompiled)require.__markCompiled();



function getBlankIframeSrc(){return __bodyWrapper(this,arguments,function(){
return UA.ie() < 10?'javascript:false':'about:blank';},{returns:'string'});}__annotator(getBlankIframeSrc,{'module':'getBlankIframeSrc','line':16,'column':0,'endLine':18,'endColumn':1,'name':'getBlankIframeSrc'},{returns:'string'});


module.exports = getBlankIframeSrc;},{'module':'getBlankIframeSrc','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_getBlankIframeSrc'}),null);

__d('insertIframe',['GlobalCallback','getBlankIframeSrc','guid'],__annotator(function $module_insertIframe(global,require,requireDynamic,requireLazy,module,exports,GlobalCallback,getBlankIframeSrc,guid){if(require.__markCompiled)require.__markCompiled();






function insertIframe(opts){return __bodyWrapper(this,arguments,function(){






opts.id = opts.id || guid();
opts.name = opts.name || guid();






var srcSet=false;
var onloadDone=false;
var callback=__annotator(function(){
if(srcSet && !onloadDone){
onloadDone = true;
opts.onload && opts.onload(opts.root.firstChild);}},{'module':'insertIframe','line':45,'column':17,'endLine':50,'endColumn':3});


var globalCallback=GlobalCallback.create(callback);






if(document.attachEvent){


var html=
'<iframe' +
' id="' + opts.id + '"' +
' name="' + opts.name + '"' + (
opts.title?' title="' + opts.title + '"':'') + (
opts.className?' class="' + opts.className + '"':'') +
' style="border:none;' + (
opts.width?'width:' + opts.width + 'px;':'') + (
opts.height?'height:' + opts.height + 'px;':'') +
'"' +
' src="' + getBlankIframeSrc() + '"' +
' frameborder="0"' +
' scrolling="no"' +
' allowtransparency="true"' +
' onload="' + globalCallback + '()"' +
'></iframe>';










opts.root.innerHTML =
'<iframe src="' + getBlankIframeSrc() + '"' +
' frameborder="0"' +
' scrolling="no"' +
' style="height:1px"></iframe>';



srcSet = true;






setTimeout(__annotator(function(){
opts.root.innerHTML = html;
opts.root.firstChild.src = opts.url;
opts.onInsert && opts.onInsert(opts.root.firstChild);},{'module':'insertIframe','line':102,'column':15,'endLine':106,'endColumn':5}),
0);}else

{



var node=document.createElement('iframe');
node.id = opts.id;
node.name = opts.name;
node.onload = callback;
node.scrolling = 'no';
node.style.border = 'none';
node.style.overflow = 'hidden';
if(opts.title){
node.title = opts.title;}

if(opts.className){
node.className = opts.className;}

if(opts.height !== undefined){
node.style.height = opts.height + 'px';}

if(opts.width !== undefined){
if(opts.width == '100%'){
node.style.width = opts.width;}else
{
node.style.width = opts.width + 'px';}}


opts.root.appendChild(node);


srcSet = true;

node.src = opts.url;
opts.onInsert && opts.onInsert(node);}},{params:[[opts,'object','opts']]});}__annotator(insertIframe,{'module':'insertIframe','line':28,'column':0,'endLine':143,'endColumn':1,'name':'insertIframe'},{params:['object']});



module.exports = insertIframe;},{'module':'insertIframe','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_insertIframe'}),null);

__d('sdk.domReady',[],__annotator(function $module_sdk_domReady(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();
var queue;
var domIsReady="readyState" in document?
/loaded|complete/.test(document.readyState):





!!document.body;

function flush(){
if(!queue){
return;}


var fn;
while(fn = queue.shift()) {
fn();}

queue = null;}__annotator(flush,{'module':'sdk.domReady','line':18,'column':0,'endLine':28,'endColumn':1,'name':'flush'});


function domReady(fn){return __bodyWrapper(this,arguments,function(){
if(queue){
queue.push(fn);
return;}else
{
fn();}},{params:[[fn,'function','fn']]});}__annotator(domReady,{'module':'sdk.domReady','line':30,'column':0,'endLine':37,'endColumn':1,'name':'domReady'},{params:['function']});



if(!domIsReady){
queue = [];
if(document.addEventListener){
document.addEventListener('DOMContentLoaded',flush,false);
window.addEventListener('load',flush,false);}else
if(document.attachEvent){
document.attachEvent('onreadystatechange',flush);
window.attachEvent('onload',flush);}




if(document.documentElement.doScroll && window == window.top){
var test=__annotator(function(){
try{


document.documentElement.doScroll('left');}
catch(error) {
setTimeout(test,0);
return;}

flush();},{'module':'sdk.domReady','line':52,'column':15,'endLine':62,'endColumn':5});

test();}}



module.exports = domReady;},{'module':'sdk.domReady','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_domReady'}),3);

__d('sdk.Content',['Log','sdk.UA','sdk.domReady'],__annotator(function $module_sdk_Content(global,require,requireDynamic,requireLazy,module,exports,Log,UA,domReady){if(require.__markCompiled)require.__markCompiled();






var visibleRoot;
var hiddenRoot;

var Content={








append:__annotator(function(content,root){return __bodyWrapper(this,arguments,function()
{


if(!root){
if(!visibleRoot){
visibleRoot = root = document.getElementById('fb-root');
if(!root){
Log.warn('The "fb-root" div has not been created, auto-creating');

visibleRoot = root = document.createElement('div');
root.id = 'fb-root';






if(UA.ie() || !document.body){
domReady(__annotator(function(){
document.body.appendChild(root);},{'module':'sdk.Content','line':44,'column':21,'endLine':46,'endColumn':13}));}else

{
document.body.appendChild(root);}}


root.className += ' fb_reset';}else
{
root = visibleRoot;}}



if(typeof content == 'string'){
var div=document.createElement('div');
root.appendChild(div).innerHTML = content;
return div;}else
{
return root.appendChild(content);}},{params:[[content,'HTMLElement|string','content'],[root,'?HTMLElement','root']],returns:'HTMLElement'});},{'module':'sdk.Content','line':25,'column':10,'endLine':64,'endColumn':3},{params:['HTMLElement|string','?HTMLElement'],returns:'HTMLElement'}),









appendHidden:__annotator(function(content){return __bodyWrapper(this,arguments,function(){
if(!hiddenRoot){
var
hiddenRoot=document.createElement('div'),
style=hiddenRoot.style;
style.position = 'absolute';
style.top = '-10000px';
style.width = style.height = 0;
hiddenRoot = Content.append(hiddenRoot);}


return Content.append(content,hiddenRoot);},{params:[[content,'HTMLElement|string','content']],returns:'HTMLElement'});},{'module':'sdk.Content','line':72,'column':16,'endLine':84,'endColumn':3},{params:['HTMLElement|string'],returns:'HTMLElement'}),














submitToTarget:__annotator(function(opts,get){return __bodyWrapper(this,arguments,function(){
var form=document.createElement('form');
form.action = opts.url;
form.target = opts.target;
form.method = get?'GET':'POST';
Content.appendHidden(form);

for(var key in opts.params) {
if(opts.params.hasOwnProperty(key)){
var val=opts.params[key];
if(val !== null && val !== undefined){
var input=document.createElement('input');
input.name = key;
input.value = val;
form.appendChild(input);}}}




form.submit();
form.parentNode.removeChild(form);},{params:[[opts,'object','opts'],[get,'?boolean','get']]});},{'module':'sdk.Content','line':98,'column':18,'endLine':119,'endColumn':3},{params:['object','?boolean']})};



module.exports = Content;},{'module':'sdk.Content','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Content'}),null);

__d('sdk.Impressions',['sdk.Content','Miny','QueryString','sdk.Runtime','UrlMap','getBlankIframeSrc','guid','insertIframe'],__annotator(function $module_sdk_Impressions(global,require,requireDynamic,requireLazy,module,exports,Content,Miny,QueryString,Runtime,UrlMap,getBlankIframeSrc,guid,insertIframe){if(require.__markCompiled)require.__markCompiled();











function request(params){return __bodyWrapper(this,arguments,function(){
var clientID=Runtime.getClientID();

if(!params.api_key && clientID){
params.api_key = clientID;}


params.kid_directed_site = Runtime.getKidDirectedSite();

var url=UrlMap.resolve('www',true) +
'/impression.php/' + guid() + '/';
var fullUrlPath=QueryString.appendToUrl(url,params);
if(fullUrlPath.length > 2000){


if(params.payload && typeof params.payload === 'string'){
var minyPayload=Miny.encode(params.payload);
if(minyPayload && minyPayload.length < params.payload.length){
params.payload = minyPayload;
fullUrlPath = QueryString.appendToUrl(url,params);}}}




if(fullUrlPath.length <= 2000){
var image=new Image();
image.src = fullUrlPath;}else
{

var name=guid();
var root=Content.appendHidden('');
insertIframe({
url:getBlankIframeSrc(),
root:root,
name:name,
className:'fb_hidden fb_invisible',
onload:__annotator(function(){
root.parentNode.removeChild(root);},{'module':'sdk.Impressions','line':54,'column':14,'endLine':56,'endColumn':7})});



Content.submitToTarget({
url:url,
target:name,
params:params});}},{params:[[params,'object','params']]});}__annotator(request,{'module':'sdk.Impressions','line':18,'column':0,'endLine':65,'endColumn':1,'name':'request'},{params:['object']});




var Impressions={
log:__annotator(function(lid,payload){return __bodyWrapper(this,arguments,function(){
if(!payload.source){
payload.source = 'jssdk';}


request({
lid:lid,
payload:ES('JSON','stringify',false,payload)});},{params:[[lid,'number','lid'],[payload,'object','payload']]});},{'module':'sdk.Impressions','line':68,'column':7,'endLine':77,'endColumn':3},{params:['number','object']}),



impression:request};


module.exports = Impressions;},{'module':'sdk.Impressions','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Impressions'}),null);

__d('Base64',[],__annotator(function $module_Base64(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();













var en=
'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
function en3(c){
c = c.charCodeAt(0) << 16 | c.charCodeAt(1) << 8 | c.charCodeAt(2);
return String.fromCharCode(
en.charCodeAt(c >>> 18),en.charCodeAt(c >>> 12 & 63),
en.charCodeAt(c >>> 6 & 63),en.charCodeAt(c & 63));}__annotator(en3,{'module':'Base64','line':34,'column':0,'endLine':39,'endColumn':1,'name':'en3'});





var de=
'>___?456789:;<=_______' +
'\x00\x01\x02\x03\x04\x05\x06\x07\b\t\n\x0b\f\r\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19' +
'______\x1a\x1b\x1c\x1d\x1e\x1f !"#$%&\'()*+,-./0123';
function de4(c){
c = de.charCodeAt(c.charCodeAt(0) - 43) << 18 |
de.charCodeAt(c.charCodeAt(1) - 43) << 12 |
de.charCodeAt(c.charCodeAt(2) - 43) << 6 |
de.charCodeAt(c.charCodeAt(3) - 43);
return String.fromCharCode(c >>> 16,c >>> 8 & 255,c & 255);}__annotator(de4,{'module':'Base64','line':48,'column':0,'endLine':54,'endColumn':1,'name':'de4'});


var Base64={
encode:__annotator(function(s){

s = unescape(encodeURI(s));
var i=(s.length + 2) % 3;
s = (s + '\0\0'.slice(i)).replace(/[\s\S]{3}/g,en3);
return s.slice(0,s.length + i - 2) + '=='.slice(i);},{'module':'Base64','line':57,'column':10,'endLine':63,'endColumn':3}),

decode:__annotator(function(s){

s = s.replace(/[^A-Za-z0-9+\/]/g,'');
var i=s.length + 3 & 3;
s = (s + 'AAA'.slice(i)).replace(/..../g,de4);
s = s.slice(0,s.length + i - 3);

try{return decodeURIComponent(escape(s));}
catch(_) {throw new Error('Not valid UTF-8');}},{'module':'Base64','line':64,'column':10,'endLine':73,'endColumn':3}),

encodeObject:__annotator(function(obj){
return Base64.encode(ES('JSON','stringify',false,obj));},{'module':'Base64','line':74,'column':16,'endLine':76,'endColumn':3}),

decodeObject:__annotator(function(b64){
return ES('JSON','parse',false,Base64.decode(b64));},{'module':'Base64','line':77,'column':16,'endLine':79,'endColumn':3}),


encodeNums:__annotator(function(l){
return String.fromCharCode.apply(String,ES(l,'map',true,__annotator(function(val){
return en.charCodeAt((val | -(val > 63)) & -(val > 0) & 63);},{'module':'Base64','line':82,'column':51,'endLine':84,'endColumn':5})));},{'module':'Base64','line':81,'column':14,'endLine':85,'endColumn':3})};




module.exports = Base64;},{'module':'Base64','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_Base64'}),null);

__d('sdk.SignedRequest',['Base64'],__annotator(function $module_sdk_SignedRequest(global,require,requireDynamic,requireLazy,module,exports,Base64){if(require.__markCompiled)require.__markCompiled();



function parse(signed_request){return __bodyWrapper(this,arguments,function(){
if(!signed_request){
return null;}



var payload=signed_request.split('.',2)[1].
replace(/\-/g,'+').replace(/\_/g,'/');
return Base64.decodeObject(payload);},{params:[[signed_request,'?string','signed_request']],returns:'?object'});}__annotator(parse,{'module':'sdk.SignedRequest','line':17,'column':0,'endLine':26,'endColumn':1,'name':'parse'},{params:['?string'],returns:'?object'});



var SignedRequest={
parse:parse};


module.exports = SignedRequest;},{'module':'sdk.SignedRequest','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_SignedRequest'}),null);

__d('URIRFC3986',[],__annotator(function $module_URIRFC3986(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var PARSE_PATTERN=new RegExp(
'^' +
'([^:/?#]+:)?' +
'(//' +
'([^\\\\/?#@]*@)?' +
'(' +
'\\[[A-Fa-f0-9:.]+\\]|' +
'[^\\/?#:]*' +
')' +
'(:[0-9]*)?' +
')?' +
'([^?#]*)' +
'(\\?[^#]*)?' +
'(#.*)?');








var URIRFC3986={








parse:__annotator(function(uriString){return __bodyWrapper(this,arguments,function(){
if(ES(uriString,'trim',true) === ''){
return null;}

var captures=uriString.match(PARSE_PATTERN);
var uri={};




uri.uri = captures[0]?captures[0]:null;
uri.scheme = captures[1]?
captures[1].substr(0,captures[1].length - 1):
null;
uri.authority = captures[2]?captures[2].substr(2):null;
uri.userinfo = captures[3]?
captures[3].substr(0,captures[3].length - 1):
null;
uri.host = captures[2]?captures[4]:null;
uri.port = captures[5]?
captures[5].substr(1)?parseInt(captures[5].substr(1),10):null:
null;
uri.path = captures[6]?captures[6]:null;
uri.query = captures[7]?captures[7].substr(1):null;
uri.fragment = captures[8]?captures[8].substr(1):null;
uri.isGenericURI = uri.authority === null && !!uri.scheme;
return uri;},{params:[[uriString,'string','uriString']],returns:'?object'});},{'module':'URIRFC3986','line':52,'column':9,'endLine':79,'endColumn':3},{params:['string'],returns:'?object'})};



module.exports = URIRFC3986;},{'module':'URIRFC3986','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_URIRFC3986'}),null);

__d('createObjectFrom',[],__annotator(function $module_createObjectFrom(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();
























function createObjectFrom(
keys,
values)
{
if(__DEV__){
if(!ES('Array','isArray',false,keys)){
throw new TypeError('Must pass an array of keys.');}}



var object={};
var isArray=ES('Array','isArray',false,values);
if(values === undefined){
values = true;}


for(var ii=keys.length - 1;ii >= 0;ii--) {
object[keys[ii]] = isArray?values[ii]:values;}

return object;}__annotator(createObjectFrom,{'module':'createObjectFrom','line':44,'column':0,'endLine':64,'endColumn':1,'name':'createObjectFrom'});


module.exports = createObjectFrom;},{'module':'createObjectFrom','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_createObjectFrom'}),null);

__d('URISchemes',['createObjectFrom'],__annotator(function $module_URISchemes(global,require,requireDynamic,requireLazy,module,exports,createObjectFrom){if(require.__markCompiled)require.__markCompiled();



var defaultSchemes=createObjectFrom([
'blob',
'fb',
'fb-ama',
'fb-messenger',
'fbcf',
'fbconnect',
'fbmobilehome',
'fbrpc',
'file',
'ftp',
'http',
'https',
'mailto',
'ms-app',
'intent',
'itms',
'itms-apps',
'itms-services',
'market',
'svn+ssh',
'fbstaging',
'tel',
'sms',
'pebblejs',
'sftp']);


var URISchemes={





isAllowed:__annotator(function(schema){return __bodyWrapper(this,arguments,function(){
if(!schema){
return true;}

return defaultSchemes.hasOwnProperty(schema.toLowerCase());},{params:[[schema,'?string','schema']],returns:'boolean'});},{'module':'URISchemes','line':57,'column':13,'endLine':62,'endColumn':3},{params:['?string'],returns:'boolean'})};



module.exports = URISchemes;},{'module':'URISchemes','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_URISchemes'}),null);

__d('eprintf',[],__annotator(function $module_eprintf(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();











var eprintf=__annotator(function(errorMessage){return __bodyWrapper(this,arguments,function(){
var args=ES(Array.prototype.slice.call(arguments),'map',true,__annotator(function(arg){
return String(arg);},{'module':'eprintf','line':33,'column':55,'endLine':35,'endColumn':3}));

var expectedLength=errorMessage.split('%s').length - 1;

if(expectedLength !== args.length - 1){

return eprintf('eprintf args number mismatch: %s',ES('JSON','stringify',false,args));}


var index=1;
return errorMessage.replace(/%s/g,__annotator(function(whole){
return String(args[index++]);},{'module':'eprintf','line':44,'column':37,'endLine':46,'endColumn':3}));},{params:[[errorMessage,'string','errorMessage']]});},{'module':'eprintf','line':32,'column':14,'endLine':47,'endColumn':1},{params:['string']});



module.exports = eprintf;},{'module':'eprintf','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_eprintf'}),null);

__d('ex',['eprintf'],__annotator(function $module_ex(global,require,requireDynamic,requireLazy,module,exports,eprintf){if(require.__markCompiled)require.__markCompiled();

















var ex=__annotator(function(){for(var _len=arguments.length,args=Array(_len),_key=0;_key < _len;_key++) {args[_key] = arguments[_key];}
args = ES(args,'map',true,__annotator(function(arg){return String(arg);},{'module':'ex','line':39,'column':18,'endLine':39,'endColumn':38}));
if(args[0].split('%s').length !== args.length){

return ex('ex args number mismatch: %s',ES('JSON','stringify',false,args));}


if(__DEV__){
return eprintf.apply(null,args);}else
{
return ex._prefix + ES('JSON','stringify',false,args) + ex._suffix;}},{'module':'ex','line':38,'column':9,'endLine':50,'endColumn':1});




ex._prefix = '<![EX[';
ex._suffix = ']]>';

module.exports = ex;},{'module':'ex','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ex'}),null);

__d('invariant',['ex','sprintf'],__annotator(function $module_invariant(global,require,requireDynamic,requireLazy,module,exports,ex,sprintf){



'use strict';if(require.__markCompiled)require.__markCompiled();




var printingFunction=ex;
if(__DEV__){
printingFunction = sprintf;}












function invariant(condition,format){
if(__DEV__){
if(format === undefined){
throw new Error('invariant requires an error message argument');}}



if(!condition){
var error;
if(format === undefined){
error = new Error(
'Minified exception occurred; use the non-minified dev environment ' +
'for the full error message and additional helpful warnings.');}else

{
var messageWithParams=[format];
for(var i=2,l=arguments.length;i < l;i++) {
messageWithParams.push(arguments[i]);}

error = new Error(printingFunction.apply(null,messageWithParams));
error.name = 'Invariant Violation';
error.messageWithParams = messageWithParams;}


error.framesToPop = 1;
throw error;}}__annotator(invariant,{'module':'invariant','line':54,'column':0,'endLine':81,'endColumn':1,'name':'invariant'});



module.exports = invariant;},{'module':'invariant','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_invariant'}),null);

__d('URIBase',['URIRFC3986','URISchemes','ex','invariant'],__annotator(function $module_URIBase(global,require,requireDynamic,requireLazy,module,exports,URIRFC3986,URISchemes,ex,invariant){if(require.__markCompiled)require.__markCompiled();







var UNSAFE_DOMAIN_PATTERN=new RegExp(


'[\\x00-\\x2c\\x2f\\x3b-\\x40\\x5c\\x5e\\x60\\x7b-\\x7f' +

'\\uFDD0-\\uFDEF\\uFFF0-\\uFFFF' +

'\\u2047\\u2048\\uFE56\\uFE5F\\uFF03\\uFF0F\\uFF1F]');


var SECURITY_PATTERN=new RegExp(

'^(?:[^/]*:|' +

'[\\x00-\\x1f]*/[\\x00-\\x1f]*/)');














function parse(uri,uriToParse,shouldThrow,serializer){
if(!uriToParse){
return true;}



if(uriToParse instanceof URIBase){
uri.setProtocol(uriToParse.getProtocol());
uri.setDomain(uriToParse.getDomain());
uri.setPort(uriToParse.getPort());
uri.setPath(uriToParse.getPath());
uri.setQueryData(
serializer.deserialize(
serializer.serialize(uriToParse.getQueryData())));


uri.setFragment(uriToParse.getFragment());
uri.setForceFragmentSeparator(uriToParse.getForceFragmentSeparator());
return true;}


uriToParse = ES(uriToParse.toString(),'trim',true);
var components=URIRFC3986.parse(uriToParse) || {};
if(!shouldThrow && !URISchemes.isAllowed(components.scheme)){
return false;}

uri.setProtocol(components.scheme || '');
if(!shouldThrow && UNSAFE_DOMAIN_PATTERN.test(components.host)){
return false;}

uri.setDomain(components.host || '');
uri.setPort(components.port || '');
uri.setPath(components.path || '');
if(shouldThrow){
uri.setQueryData(serializer.deserialize(components.query) || {});}else
{
try{
uri.setQueryData(serializer.deserialize(components.query) || {});}
catch(err) {
return false;}}


uri.setFragment(components.fragment || '');


if(components.fragment === ''){
uri.setForceFragmentSeparator(true);}


if(components.userinfo !== null){
if(shouldThrow){
throw new Error(ex(
'URI.parse: invalid URI (userinfo is not allowed in a URI): %s',
uri.toString()));}else

{
return false;}}





if(!uri.getDomain() && ES(uri.getPath(),'indexOf',true,'\\') !== -1){
if(shouldThrow){
throw new Error(ex(
'URI.parse: invalid URI (no domain but multiple back-slashes): %s',
uri.toString()));}else

{
return false;}}





if(!uri.getProtocol() && SECURITY_PATTERN.test(uriToParse)){
if(shouldThrow){
throw new Error(ex(
'URI.parse: invalid URI (unsafe protocol-relative URLs): %s',
uri.toString()));}else

{
return false;}}


return true;}__annotator(parse,{'module':'URIBase','line':55,'column':0,'endLine':141,'endColumn':1,'name':'parse'});





var uriFilters=[];
































function URIBase(uri,serializer){'use strict';
!serializer?invariant(0,'no serializer set'):undefined;
this.$URIBase_serializer = serializer;

this.$URIBase_protocol = '';
this.$URIBase_domain = '';
this.$URIBase_port = '';
this.$URIBase_path = '';
this.$URIBase_fragment = '';
this.$URIBase_queryData = {};
this.$URIBase_forceFragmentSeparator = false;
parse(this,uri,true,serializer);}__annotator(URIBase,{'module':'URIBase','line':179,'column':2,'endLine':191,'endColumn':3,'name':'URIBase'});URIBase.prototype.








setProtocol = __annotator(function(protocol){'use strict';
!
URISchemes.isAllowed(protocol)?invariant(0,
'"%s" is not a valid protocol for a URI.',protocol):undefined;

this.$URIBase_protocol = protocol;
return this;},{'module':'URIBase','line':199,'column':13,'endLine':206,'endColumn':3});URIBase.prototype.







getProtocol = __annotator(function(protocol){'use strict';
return this.$URIBase_protocol;},{'module':'URIBase','line':213,'column':13,'endLine':215,'endColumn':3});URIBase.prototype.








setSecure = __annotator(function(secure){'use strict';
return this.setProtocol(secure?'https':'http');},{'module':'URIBase','line':223,'column':11,'endLine':225,'endColumn':3});URIBase.prototype.







isSecure = __annotator(function(){'use strict';
return this.getProtocol() === 'https';},{'module':'URIBase','line':232,'column':10,'endLine':234,'endColumn':3});URIBase.prototype.








setDomain = __annotator(function(domain){'use strict';




if(UNSAFE_DOMAIN_PATTERN.test(domain)){
throw new Error(ex(
'URI.setDomain: unsafe domain specified: %s for url %s',
domain,
this.toString()));}



this.$URIBase_domain = domain;
return this;},{'module':'URIBase','line':242,'column':11,'endLine':257,'endColumn':3});URIBase.prototype.







getDomain = __annotator(function(){'use strict';
return this.$URIBase_domain;},{'module':'URIBase','line':264,'column':11,'endLine':266,'endColumn':3});URIBase.prototype.








setPort = __annotator(function(port){'use strict';
this.$URIBase_port = port;
return this;},{'module':'URIBase','line':274,'column':9,'endLine':277,'endColumn':3});URIBase.prototype.







getPort = __annotator(function(){'use strict';
return this.$URIBase_port;},{'module':'URIBase','line':284,'column':9,'endLine':286,'endColumn':3});URIBase.prototype.








setPath = __annotator(function(path){'use strict';
if(__DEV__){
if(path && path.charAt(0) !== '/'){
console.warn('Path does not begin with a "/" which means this URI ' +
'will likely be malformed. Ensure any string passed to .setPath() ' +
'leads with "/"');}}


this.$URIBase_path = path;
return this;},{'module':'URIBase','line':294,'column':9,'endLine':304,'endColumn':3});URIBase.prototype.







getPath = __annotator(function(){'use strict';
return this.$URIBase_path;},{'module':'URIBase','line':311,'column':9,'endLine':313,'endColumn':3});URIBase.prototype.









addQueryData = __annotator(function(mapOrKey,value){'use strict';

if(Object.prototype.toString.call(mapOrKey) === '[object Object]'){
ES('Object','assign',false,this.$URIBase_queryData,mapOrKey);}else
{
this.$URIBase_queryData[mapOrKey] = value;}

return this;},{'module':'URIBase','line':322,'column':14,'endLine':330,'endColumn':3});URIBase.prototype.









setQueryData = __annotator(function(map){'use strict';
this.$URIBase_queryData = map;
return this;},{'module':'URIBase','line':339,'column':14,'endLine':342,'endColumn':3});URIBase.prototype.







getQueryData = __annotator(function(){'use strict';
return this.$URIBase_queryData;},{'module':'URIBase','line':349,'column':14,'endLine':351,'endColumn':3});URIBase.prototype.








removeQueryData = __annotator(function(keys){'use strict';
if(!ES('Array','isArray',false,keys)){
keys = [keys];}

for(var i=0,length=keys.length;i < length;++i) {
delete this.$URIBase_queryData[keys[i]];}

return this;},{'module':'URIBase','line':359,'column':17,'endLine':367,'endColumn':3});URIBase.prototype.








setFragment = __annotator(function(fragment){'use strict';
this.$URIBase_fragment = fragment;

this.setForceFragmentSeparator(false);
return this;},{'module':'URIBase','line':375,'column':13,'endLine':380,'endColumn':3});URIBase.prototype.







getFragment = __annotator(function(){'use strict';
return this.$URIBase_fragment;},{'module':'URIBase','line':387,'column':13,'endLine':389,'endColumn':3});URIBase.prototype.

















setForceFragmentSeparator = __annotator(function(shouldForce){'use strict';
this.$URIBase_forceFragmentSeparator = shouldForce;
return this;},{'module':'URIBase','line':406,'column':27,'endLine':409,'endColumn':3});URIBase.prototype.








getForceFragmentSeparator = __annotator(function(){'use strict';
return this.$URIBase_forceFragmentSeparator;},{'module':'URIBase','line':417,'column':27,'endLine':419,'endColumn':3});URIBase.prototype.







isEmpty = __annotator(function(){'use strict';
return !(
this.getPath() ||
this.getProtocol() ||
this.getDomain() ||
this.getPort() ||
ES('Object','keys',false,this.getQueryData()).length > 0 ||
this.getFragment());},{'module':'URIBase','line':426,'column':9,'endLine':435,'endColumn':3});URIBase.prototype.








toString = __annotator(function(){'use strict';
var uri=this;
for(var i=0;i < uriFilters.length;i++) {
uri = uriFilters[i](uri);}

return uri.$URIBase_toStringImpl();},{'module':'URIBase','line':442,'column':10,'endLine':448,'endColumn':3});URIBase.prototype.








$URIBase_toStringImpl = __annotator(function(){'use strict';
var str='';
var protocol=this.getProtocol();
if(protocol){
str += protocol + '://';}

var domain=this.getDomain();
if(domain){
str += domain;}

var port=this.getPort();
if(port){
str += ':' + port;}





var path=this.getPath();
if(path){
str += path;}else
if(str){
str += '/';}

var queryStr=this.$URIBase_serializer.serialize(this.getQueryData());
if(queryStr){
str += '?' + queryStr;}

var fragment=this.getFragment();
if(fragment){
str += '#' + fragment;}else
if(this.getForceFragmentSeparator()){
str += '#';}

return str;},{'module':'URIBase','line':456,'column':15,'endLine':491,'endColumn':3});URIBase.









registerFilter = __annotator(function(filter){'use strict';
uriFilters.push(filter);},{'module':'URIBase','line':500,'column':23,'endLine':502,'endColumn':3});URIBase.prototype.






getOrigin = __annotator(function(){'use strict';
var port=this.getPort();
return this.getProtocol() +
'://' +
this.getDomain() + (
port?':' + port:'');},{'module':'URIBase','line':508,'column':11,'endLine':514,'endColumn':3});













URIBase.isValidURI = __annotator(function(uri,serializer){
return parse(new URIBase(null,serializer),uri,false,serializer);},{'module':'URIBase','line':527,'column':21,'endLine':529,'endColumn':1});


module.exports = URIBase;},{'module':'URIBase','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_URIBase'}),null);

__d('sdk.URI',['Assert','QueryString','URIBase'],__annotator(function $module_sdk_URI(global,require,requireDynamic,requireLazy,module,exports,Assert,QueryString,URIBase){if(require.__markCompiled)require.__markCompiled();var _URIBase,_superProto;





var facebookRe=/\.facebook\.com$/;

var serializer={
serialize:__annotator(function(map){
return map?
QueryString.encode(map):
'';},{'module':'sdk.URI','line':27,'column':13,'endLine':31,'endColumn':3}),

deserialize:__annotator(function(text){
return text?
QueryString.decode(text):
{};},{'module':'sdk.URI','line':32,'column':15,'endLine':36,'endColumn':3})};_URIBase = babelHelpers.inherits(



URI,URIBase);_superProto = _URIBase && _URIBase.prototype;
function URI(uri){'use strict';
Assert.isString(uri,'The passed argument was of invalid type.');
_superProto.constructor.call(this,uri,serializer);}__annotator(URI,{'module':'sdk.URI','line':40,'column':2,'endLine':43,'endColumn':3,'name':'URI'});URI.prototype.


isFacebookURI = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return facebookRe.test(this.getDomain());},{returns:'boolean'});},{'module':'sdk.URI','line':45,'column':15,'endLine':47,'endColumn':3},{returns:'boolean'});URI.prototype.


valueOf = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.toString();},{returns:'string'});},{'module':'sdk.URI','line':49,'column':9,'endLine':51,'endColumn':3},{returns:'string'});



module.exports = URI;},{'module':'sdk.URI','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_URI'}),null);

__d('Queue',[],__annotator(function $module_Queue(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();




var registry={};







function Queue(opts){'use strict';

this._opts = babelHelpers._extends({
interval:0,
processor:null},
opts);



this._queue = [];
this._stopped = true;}__annotator(Queue,{'module':'Queue','line':44,'column':2,'endLine':55,'endColumn':3,'name':'Queue'});Queue.prototype.









_dispatch = __annotator(function(force){'use strict';
if(this._stopped || this._queue.length === 0){
return;}

if(!this._opts.processor){
this._stopped = true;
throw new Error('No processor available');}


if(this._opts.interval){
this._opts.processor.call(this,this._queue.shift());
this._timeout = setTimeout(ES(
this._dispatch,'bind',true,this),
this._opts.interval);}else

{
while(this._queue.length) {
this._opts.processor.call(this,this._queue.shift());}}},{'module':'Queue','line':64,'column':11,'endLine':84,'endColumn':3});Queue.prototype.












enqueue = __annotator(function(message){'use strict';
if(this._opts.processor && !this._stopped){
this._opts.processor.call(this,message);}else
{
this._queue.push(message);}

return this;},{'module':'Queue','line':94,'column':9,'endLine':101,'endColumn':3});Queue.prototype.









start = __annotator(function(processor){'use strict';
if(processor){
this._opts.processor = processor;}

this._stopped = false;
this._dispatch();
return this;},{'module':'Queue','line':110,'column':7,'endLine':117,'endColumn':3});Queue.prototype.


isStarted = __annotator(function(){'use strict';
return !this._stopped;},{'module':'Queue','line':119,'column':11,'endLine':121,'endColumn':3});Queue.prototype.






dispatch = __annotator(function(){'use strict';
this._dispatch(true);},{'module':'Queue','line':127,'column':10,'endLine':129,'endColumn':3});Queue.prototype.








stop = __annotator(function(scheduled){'use strict';
this._stopped = true;
if(scheduled){
clearTimeout(this._timeout);}

return this;},{'module':'Queue','line':137,'column':6,'endLine':143,'endColumn':3});Queue.prototype.










merge = __annotator(function(queue,prepend){'use strict';
this._queue[prepend?'unshift':'push'].
apply(this._queue,queue._queue);
queue._queue = [];
this._dispatch();
return this;},{'module':'Queue','line':153,'column':7,'endLine':159,'endColumn':3});Queue.prototype.





getLength = __annotator(function(){'use strict';
return this._queue.length;},{'module':'Queue','line':164,'column':11,'endLine':166,'endColumn':3});Queue.










get = __annotator(function(name,opts){'use strict';
var queue;
if(name in registry){
queue = registry[name];}else
{
queue = registry[name] = new Queue(opts);}

return queue;},{'module':'Queue','line':176,'column':12,'endLine':184,'endColumn':3});Queue.








exists = __annotator(function(name){'use strict';
return name in registry;},{'module':'Queue','line':192,'column':15,'endLine':194,'endColumn':3});Queue.









remove = __annotator(function(name){'use strict';
return delete registry[name];},{'module':'Queue','line':203,'column':15,'endLine':205,'endColumn':3});




module.exports = Queue;},{'module':'Queue','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_Queue'}),null);

__d('DOMEventListener',['wrapFunction'],__annotator(function $module_DOMEventListener(global,require,requireDynamic,requireLazy,module,exports,wrapFunction){if(require.__markCompiled)require.__markCompiled();



var add,remove;

if(window.addEventListener){


add = __annotator(function(target,name,listener){return __bodyWrapper(this,arguments,function(){
listener.wrapper =
wrapFunction(listener,'entry','DOMEventListener.add ' + name);
target.addEventListener(name,listener.wrapper,false);},{params:[[name,'string','name'],[listener,'function','listener']]});},{'module':'DOMEventListener','line':23,'column':8,'endLine':27,'endColumn':3},{params:['string','function']});

remove = __annotator(function(target,name,listener){return __bodyWrapper(this,arguments,function(){
target.removeEventListener(name,listener.wrapper,false);},{params:[[name,'string','name'],[listener,'function','listener']]});},{'module':'DOMEventListener','line':28,'column':11,'endLine':30,'endColumn':3},{params:['string','function']});}else


if(window.attachEvent){


add = __annotator(function(target,name,listener){return __bodyWrapper(this,arguments,function(){
listener.wrapper =
wrapFunction(listener,'entry','DOMEventListener.add ' + name);
target.attachEvent('on' + name,listener.wrapper);},{params:[[name,'string','name'],[listener,'function','listener']]});},{'module':'DOMEventListener','line':35,'column':8,'endLine':39,'endColumn':3},{params:['string','function']});

remove = __annotator(function(target,name,listener){return __bodyWrapper(this,arguments,function(){
target.detachEvent('on' + name,listener.wrapper);},{params:[[name,'string','name'],[listener,'function','listener']]});},{'module':'DOMEventListener','line':40,'column':11,'endLine':42,'endColumn':3},{params:['string','function']});}else


{
remove = add = __annotator(function(){},{'module':'DOMEventListener','line':45,'column':17,'endLine':45,'endColumn':25});}


var DOMEventListener={











add:__annotator(function(target,name,listener){return __bodyWrapper(this,arguments,function(){


add(target,name,listener);
return {



remove:__annotator(function(){
remove(target,name,listener);
target = null;},{'module':'DOMEventListener','line':68,'column':14,'endLine':71,'endColumn':7})};},{params:[[name,'string','name'],[listener,'function','listener']]});},{'module':'DOMEventListener','line':60,'column':7,'endLine':73,'endColumn':3},{params:['string','function']}),











remove:remove};


module.exports = DOMEventListener;},{'module':'DOMEventListener','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_DOMEventListener'}),null);

__d('UserAgent_DEPRECATED',[],__annotator(function $module_UserAgent_DEPRECATED(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();









































var _populated=false;


var _ie,_firefox,_opera,_webkit,_chrome;


var _ie_real_version;


var _osx,_windows,_linux,_android;


var _win64;


var _iphone,_ipad,_native;

var _mobile;

function _populate(){
if(_populated){
return;}


_populated = true;






var uas=navigator.userAgent;
var agent=/(?:MSIE.(\d+\.\d+))|(?:(?:Firefox|GranParadiso|Iceweasel).(\d+\.\d+))|(?:Opera(?:.+Version.|.)(\d+\.\d+))|(?:AppleWebKit.(\d+(?:\.\d+)?))|(?:Trident\/\d+\.\d+.*rv:(\d+\.\d+))/.exec(uas);
var os=/(Mac OS X)|(Windows)|(Linux)/.exec(uas);

_iphone = /\b(iPhone|iP[ao]d)/.exec(uas);
_ipad = /\b(iP[ao]d)/.exec(uas);
_android = /Android/i.exec(uas);
_native = /FBAN\/\w+;/i.exec(uas);
_mobile = /Mobile/i.exec(uas);






_win64 = !!/Win64/.exec(uas);

if(agent){
_ie = agent[1]?parseFloat(agent[1]):
agent[5]?parseFloat(agent[5]):NaN;

if(_ie && document && document.documentMode){
_ie = document.documentMode;}


var trident=/(?:Trident\/(\d+.\d+))/.exec(uas);
_ie_real_version = trident?parseFloat(trident[1]) + 4:_ie;

_firefox = agent[2]?parseFloat(agent[2]):NaN;
_opera = agent[3]?parseFloat(agent[3]):NaN;
_webkit = agent[4]?parseFloat(agent[4]):NaN;
if(_webkit){



agent = /(?:Chrome\/(\d+\.\d+))/.exec(uas);
_chrome = agent && agent[1]?parseFloat(agent[1]):NaN;}else
{
_chrome = NaN;}}else

{
_ie = _firefox = _opera = _chrome = _webkit = NaN;}


if(os){
if(os[1]){





var ver=/(?:Mac OS X (\d+(?:[._]\d+)?))/.exec(uas);

_osx = ver?parseFloat(ver[1].replace('_','.')):true;}else
{
_osx = false;}

_windows = !!os[2];
_linux = !!os[3];}else
{
_osx = _windows = _linux = false;}}__annotator(_populate,{'module':'UserAgent_DEPRECATED','line':66,'column':0,'endLine':140,'endColumn':1,'name':'_populate'});



var UserAgent_DEPRECATED={







ie:__annotator(function(){
return _populate() || _ie;},{'module':'UserAgent_DEPRECATED','line':150,'column':6,'endLine':152,'endColumn':3}),








ieCompatibilityMode:__annotator(function(){
return _populate() || _ie_real_version > _ie;},{'module':'UserAgent_DEPRECATED','line':160,'column':23,'endLine':162,'endColumn':3}),








ie64:__annotator(function(){
return UserAgent_DEPRECATED.ie() && _win64;},{'module':'UserAgent_DEPRECATED','line':170,'column':8,'endLine':172,'endColumn':3}),








firefox:__annotator(function(){
return _populate() || _firefox;},{'module':'UserAgent_DEPRECATED','line':180,'column':11,'endLine':182,'endColumn':3}),









opera:__annotator(function(){
return _populate() || _opera;},{'module':'UserAgent_DEPRECATED','line':191,'column':9,'endLine':193,'endColumn':3}),









webkit:__annotator(function(){
return _populate() || _webkit;},{'module':'UserAgent_DEPRECATED','line':202,'column':10,'endLine':204,'endColumn':3}),






safari:__annotator(function(){
return UserAgent_DEPRECATED.webkit();},{'module':'UserAgent_DEPRECATED','line':210,'column':10,'endLine':212,'endColumn':3}),








chrome:__annotator(function(){
return _populate() || _chrome;},{'module':'UserAgent_DEPRECATED','line':220,'column':11,'endLine':222,'endColumn':3}),








windows:__annotator(function(){
return _populate() || _windows;},{'module':'UserAgent_DEPRECATED','line':230,'column':11,'endLine':232,'endColumn':3}),









osx:__annotator(function(){
return _populate() || _osx;},{'module':'UserAgent_DEPRECATED','line':241,'column':7,'endLine':243,'endColumn':3}),







linux:__annotator(function(){
return _populate() || _linux;},{'module':'UserAgent_DEPRECATED','line':250,'column':9,'endLine':252,'endColumn':3}),








iphone:__annotator(function(){
return _populate() || _iphone;},{'module':'UserAgent_DEPRECATED','line':260,'column':10,'endLine':262,'endColumn':3}),


mobile:__annotator(function(){
return _populate() || (_iphone || _ipad || _android || _mobile);},{'module':'UserAgent_DEPRECATED','line':264,'column':10,'endLine':266,'endColumn':3}),


nativeApp:__annotator(function(){

return _populate() || _native;},{'module':'UserAgent_DEPRECATED','line':268,'column':13,'endLine':271,'endColumn':3}),


android:__annotator(function(){
return _populate() || _android;},{'module':'UserAgent_DEPRECATED','line':273,'column':11,'endLine':275,'endColumn':3}),


ipad:__annotator(function(){
return _populate() || _ipad;},{'module':'UserAgent_DEPRECATED','line':277,'column':8,'endLine':279,'endColumn':3})};



module.exports = UserAgent_DEPRECATED;},{'module':'UserAgent_DEPRECATED','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_UserAgent_DEPRECATED'}),null);

__d('htmlSpecialChars',[],__annotator(function $module_htmlSpecialChars(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();





var r_amp=/&/g;
var r_lt=/</g;
var r_gt=/>/g;
var r_quot=/"/g;
var r_squo=/'/g;







function htmlSpecialChars(text){
if(typeof text == 'undefined' || text === null || !text.toString){
return '';}


if(text === false){
return '0';}else
if(text === true){
return '1';}


return text.
toString().
replace(r_amp,'&amp;').
replace(r_quot,'&quot;').
replace(r_squo,'&#039;').
replace(r_lt,'&lt;').
replace(r_gt,'&gt;');}__annotator(htmlSpecialChars,{'module':'htmlSpecialChars','line':36,'column':0,'endLine':54,'endColumn':1,'name':'htmlSpecialChars'});


module.exports = htmlSpecialChars;},{'module':'htmlSpecialChars','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_htmlSpecialChars'}),null);

__d('Flash',['DOMEventListener','DOMWrapper','QueryString','UserAgent_DEPRECATED','guid','htmlSpecialChars'],__annotator(function $module_Flash(global,require,requireDynamic,requireLazy,module,exports,DOMEventListener,DOMWrapper,QueryString,UserAgent_DEPRECATED,guid,htmlSpecialChars){if(require.__markCompiled)require.__markCompiled();











var registry={};
var unloadHandlerAttached;
var document=DOMWrapper.getWindow().document;

function remove(id){
var swf=document.getElementById(id);
if(swf){
swf.parentNode.removeChild(swf);}

delete registry[id];}__annotator(remove,{'module':'Flash','line':29,'column':0,'endLine':35,'endColumn':1,'name':'remove'});


function unloadRegisteredSWFs(){
for(var id in registry) {
if(registry.hasOwnProperty(id)){
remove(id);}}}__annotator(unloadRegisteredSWFs,{'module':'Flash','line':37,'column':0,'endLine':43,'endColumn':1,'name':'unloadRegisteredSWFs'});







function normalize(s){
return s.replace(
/\d+/g,__annotator(
function(m){return '000'.substring(m.length) + m;},{'module':'Flash','line':51,'column':4,'endLine':51,'endColumn':58}));}__annotator(normalize,{'module':'Flash','line':48,'column':0,'endLine':53,'endColumn':1,'name':'normalize'});



function register(id){
if(!unloadHandlerAttached){


if(UserAgent_DEPRECATED.ie() >= 9){
DOMEventListener.add(window,'unload',unloadRegisteredSWFs);}

unloadHandlerAttached = true;}

registry[id] = id;}__annotator(register,{'module':'Flash','line':55,'column':0,'endLine':65,'endColumn':1,'name':'register'});



var Flash={












embed:__annotator(function(src,container,params,flashvars){

var id=guid();



src = htmlSpecialChars(src).replace(/&amp;/g,'&');


params = babelHelpers._extends({
allowscriptaccess:'always',
flashvars:flashvars,
movie:src},
params);



if(typeof params.flashvars == 'object'){
params.flashvars = QueryString.encode(params.flashvars);}



var pElements=[];
for(var key in params) {
if(params.hasOwnProperty(key) && params[key]){
pElements.push('<param name="' + htmlSpecialChars(key) + '" value="' +
htmlSpecialChars(params[key]) + '">');}}



var span=container.appendChild(document.createElement('span'));
var html=
'<object ' + (UserAgent_DEPRECATED.ie()?
'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ':
'type="application/x-shockwave-flash"') +
'data="' + src + '" ' + (
params.height?'height="' + params.height + '" ':'') + (
params.width?'width="' + params.width + '" ':'') +
'id="' + id + '">' + pElements.join('') + '</object>';
span.innerHTML = html;
var swf=span.firstChild;

register(id);
return swf;},{'module':'Flash','line':81,'column':9,'endLine':125,'endColumn':3}),







remove:remove,






getVersion:__annotator(function(){
var name='Shockwave Flash';
var mimeType='application/x-shockwave-flash';
var activexType='ShockwaveFlash.ShockwaveFlash';
var flashVersion;

if(navigator.plugins && typeof navigator.plugins[name] == 'object'){

var description=navigator.plugins[name].description;
if(description && navigator.mimeTypes &&
navigator.mimeTypes[mimeType] &&
navigator.mimeTypes[mimeType].enabledPlugin){
flashVersion = description.match(/\d+/g);}}


if(!flashVersion){
try{
flashVersion = new ActiveXObject(activexType).
GetVariable('$version').
match(/(\d+),(\d+),(\d+),(\d+)/);
flashVersion = Array.prototype.slice.call(flashVersion,1);}

catch(notSupportedException) {}}


return flashVersion;},{'module':'Flash','line':139,'column':14,'endLine':165,'endColumn':3}),






getVersionString:__annotator(function(){
var version=Flash.getVersion();
return version?version.join('.'):'';},{'module':'Flash','line':171,'column':20,'endLine':174,'endColumn':3}),









checkMinVersion:__annotator(function(minVersion){
var version=Flash.getVersion();
if(!version){
return false;}

return normalize(version.join('.')) >= normalize(minVersion);},{'module':'Flash','line':183,'column':19,'endLine':189,'endColumn':3}),







isAvailable:__annotator(function(){
return !!Flash.getVersion();},{'module':'Flash','line':196,'column':16,'endLine':198,'endColumn':3})};




module.exports = Flash;},{'module':'Flash','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_Flash'}),null);

__d("emptyFunction",[],__annotator(function $module_emptyFunction(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function makeEmptyFunction(arg){
return __annotator(function(){
return arg;},{"module":"emptyFunction","line":21,"column":9,"endLine":23,"endColumn":3});}__annotator(makeEmptyFunction,{"module":"emptyFunction","line":20,"column":0,"endLine":24,"endColumn":1,"name":"makeEmptyFunction"});








function emptyFunction(){}__annotator(emptyFunction,{"module":"emptyFunction","line":31,"column":0,"endLine":31,"endColumn":27,"name":"emptyFunction"});

emptyFunction.thatReturns = makeEmptyFunction;
emptyFunction.thatReturnsFalse = makeEmptyFunction(false);
emptyFunction.thatReturnsTrue = makeEmptyFunction(true);
emptyFunction.thatReturnsNull = makeEmptyFunction(null);
emptyFunction.thatReturnsThis = __annotator(function(){return this;},{"module":"emptyFunction","line":37,"column":32,"endLine":37,"endColumn":59});
emptyFunction.thatReturnsArgument = __annotator(function(arg){return arg;},{"module":"emptyFunction","line":38,"column":36,"endLine":38,"endColumn":65});

module.exports = emptyFunction;},{"module":"emptyFunction","line":0,"column":0,"endLine":0,"endColumn":0,"name":"$module_emptyFunction"}),null);

__d('XDM',['DOMEventListener','DOMWrapper','emptyFunction','Flash','GlobalCallback','guid','Log','UserAgent_DEPRECATED','wrapFunction'],__annotator(function $module_XDM(global,require,requireDynamic,requireLazy,module,exports,DOMEventListener,DOMWrapper,emptyFunction,Flash,GlobalCallback,guid,Log,UserAgent_DEPRECATED,wrapFunction){if(require.__markCompiled)require.__markCompiled();











var transports={};
var configuration={
transports:[]};

var window=DOMWrapper.getWindow();

function findTransport(blacklist){
var blacklistMap={},
i=blacklist.length,
list=configuration.transports;

while(i--) {blacklistMap[blacklist[i]] = 1;}

i = list.length;
while(i--) {
var name=list[i],
transport=transports[name];
if(!blacklistMap[name] && transport.isAvailable()){
return name;}}}__annotator(findTransport,{'module':'XDM','line':65,'column':0,'endLine':80,'endColumn':1,'name':'findTransport'});




var XDM={





register:__annotator(function(name,provider){
Log.debug('Registering %s as XDM provider',name);
configuration.transports.push(name);
transports[name] = provider;},{'module':'XDM','line':88,'column':12,'endLine':92,'endColumn':3}),


























create:__annotator(function(config){
if(!config.whenReady && !config.onMessage){
Log.error('An instance without whenReady or onMessage makes no sense');
throw new Error('An instance without whenReady or ' +
'onMessage makes no sense');}

if(!config.channel){
Log.warn('Missing channel name, selecting at random');
config.channel = guid();}


if(!config.whenReady){
config.whenReady = emptyFunction;}

if(!config.onMessage){
config.onMessage = emptyFunction;}


var name=config.transport || findTransport(config.blacklist || []),
transport=transports[name];
if(transport && transport.isAvailable()){
Log.debug('%s is available',name);
transport.init(config);
return name;}},{'module':'XDM','line':118,'column':10,'endLine':143,'endColumn':3})};









XDM.register('flash',__annotator(function(){
var inited=false;
var swf;
var doLog=false;
var timeout=15000;
var timer;

if(__DEV__){
doLog = true;}


return {
isAvailable:__annotator(function(){


return Flash.checkMinVersion('8.0.24');},{'module':'XDM','line':163,'column':17,'endLine':167,'endColumn':5}),

init:__annotator(function(config){
Log.debug('init flash: ' + config.channel);
var xdm={
send:__annotator(function(message,origin,windowRef,channel){
Log.debug('sending to: %s (%s)',origin,channel);
swf.postMessage(message,origin,channel);},{'module':'XDM','line':171,'column':14,'endLine':174,'endColumn':9})};


if(inited){
config.whenReady(xdm);
return;}

var div=config.root.appendChild(window.document.createElement('div'));

var callback=GlobalCallback.create(__annotator(function(){
GlobalCallback.remove(callback);
clearTimeout(timer);
Log.info('xdm.swf called the callback');
var messageCallback=GlobalCallback.create(__annotator(function(msg,origin){
msg = decodeURIComponent(msg);
origin = decodeURIComponent(origin);
Log.debug('received message %s from %s',msg,origin);
config.onMessage(msg,origin);},{'module':'XDM','line':186,'column':52,'endLine':191,'endColumn':9}),
'xdm.swf:onMessage');
swf.init(config.channel,messageCallback);
config.whenReady(xdm);},{'module':'XDM','line':182,'column':43,'endLine':194,'endColumn':7}),
'xdm.swf:load');

swf = Flash.embed(config.flashUrl,div,null,{
protocol:location.protocol.replace(':',''),
host:location.host,
callback:callback,
log:doLog});


timer = setTimeout(__annotator(function(){
Log.warn('The Flash component did not load within %s ms - ' +
'verify that the container is not set to hidden or invisible ' +
'using CSS as this will cause some browsers to not load ' +
'the components',timeout);},{'module':'XDM','line':203,'column':25,'endLine':208,'endColumn':7}),
timeout);
inited = true;},{'module':'XDM','line':168,'column':10,'endLine':210,'endColumn':5})};},{'module':'XDM','line':151,'column':23,'endLine':212,'endColumn':1})());





var facebookRe=/\.facebook\.com(\/|$)/;










XDM.register('postmessage',__annotator(function(){
var inited=false;

return {
isAvailable:__annotator(function(){
return !!window.postMessage;},{'module':'XDM','line':230,'column':18,'endLine':232,'endColumn':5}),

init:__annotator(function(config){
Log.debug('init postMessage: ' + config.channel);
var prefix='_FB_' + config.channel;
var xdm={
send:__annotator(function(message,origin,windowRef,channel){
if(window === windowRef){
Log.error('Invalid windowref, equal to window (self)');
throw new Error();}

Log.debug('sending to: %s (%s)',origin,channel);
var send=__annotator(function(){

windowRef.postMessage('_FB_' + channel + message,origin);},{'module':'XDM','line':243,'column':21,'endLine':246,'endColumn':11});









if(UserAgent_DEPRECATED.ie() == 8 || UserAgent_DEPRECATED.ieCompatibilityMode()){
setTimeout(send,0);}else
{
send();}},{'module':'XDM','line':237,'column':14,'endLine':260,'endColumn':9})};



if(inited){
config.whenReady(xdm);
return;}


DOMEventListener.add(window,'message',wrapFunction(__annotator(function(event){
var message=event.data;


var origin=event.origin || 'native';
if(!/^(https?:\/\/|native$)/.test(origin)){
Log.debug('Received message from invalid origin type: %s',origin);
return;}


if(origin !== 'native' &&
!(facebookRe.test(location.hostname) ||
facebookRe.test(event.origin))){

return;}


if(typeof message != 'string'){
Log.warn('Received message of type %s from %s, expected a string',
typeof message,origin);
return;}


Log.debug('received message %s from %s',message,origin);

if(message.substring(0,prefix.length) == prefix){
message = message.substring(prefix.length);}

config.onMessage(message,origin);},{'module':'XDM','line':267,'column':59,'endLine':296,'endColumn':7}),
'entry','onMessage'));
config.whenReady(xdm);
inited = true;},{'module':'XDM','line':233,'column':10,'endLine':299,'endColumn':5})};},{'module':'XDM','line':226,'column':29,'endLine':301,'endColumn':1})());




module.exports = XDM;},{'module':'XDM','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_XDM'}),null);

__d('isFacebookURI',[],__annotator(function $module_isFacebookURI(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var facebookURIRegex=null;

var FB_PROTOCOLS=['http','https'];








function isFacebookURI(uri){return __bodyWrapper(this,arguments,function(){
if(!facebookURIRegex){

facebookURIRegex = new RegExp('(^|\\.)facebook\\.com$','i');}


if(uri.isEmpty() && uri.toString() !== '#'){
return false;}


if(!uri.getDomain() && !uri.getProtocol()){
return true;}


return ES(FB_PROTOCOLS,'indexOf',true,uri.getProtocol()) !== -1 &&
facebookURIRegex.test(uri.getDomain());},{params:[[uri,'URI','uri']],returns:'boolean'});}__annotator(isFacebookURI,{'module':'isFacebookURI','line':32,'column':0,'endLine':48,'endColumn':1,'name':'isFacebookURI'},{params:['URI'],returns:'boolean'});


isFacebookURI.setRegex = __annotator(function(regex){
facebookURIRegex = regex;},{'module':'isFacebookURI','line':50,'column':25,'endLine':52,'endColumn':1});


module.exports = isFacebookURI;},{'module':'isFacebookURI','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_isFacebookURI'}),null);

__d('sdk.Event',[],__annotator(function $module_sdk_Event(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var Event={

SUBSCRIBE:'event.subscribe',
UNSUBSCRIBE:'event.unsubscribe',







subscribers:__annotator(function(){return __bodyWrapper(this,arguments,function(){




if(!this._subscribersMap){
this._subscribersMap = {};}

return this._subscribersMap;},{returns:'object'});},{'module':'sdk.Event','line':19,'column':15,'endLine':28,'endColumn':3},{returns:'object'}),




































subscribe:__annotator(function(name,cb){return __bodyWrapper(this,arguments,function(){
var subs=this.subscribers();

if(!subs[name]){
subs[name] = [cb];}else
{
if(ES(subs[name],'indexOf',true,cb) == -1){
subs[name].push(cb);}}


if(name != this.SUBSCRIBE && name != this.UNSUBSCRIBE){
this.fire(this.SUBSCRIBE,name,subs[name]);}},{params:[[name,'string','name'],[cb,'function','cb']]});},{'module':'sdk.Event','line':64,'column':13,'endLine':77,'endColumn':3},{params:['string','function']}),






















unsubscribe:__annotator(function(name,cb){return __bodyWrapper(this,arguments,function(){
var subs=this.subscribers()[name];
if(subs){
ES(subs,'forEach',true,__annotator(function(value,key){
if(value == cb){
subs.splice(key,1);}},{'module':'sdk.Event','line':101,'column':19,'endLine':105,'endColumn':7}));}



if(name != this.SUBSCRIBE && name != this.UNSUBSCRIBE){
this.fire(this.UNSUBSCRIBE,name,subs);}},{params:[[name,'string','name'],[cb,'function','cb']]});},{'module':'sdk.Event','line':98,'column':15,'endLine':110,'endColumn':3},{params:['string','function']}),













monitor:__annotator(function(name,callback){return __bodyWrapper(this,arguments,function(){
if(!callback()){
var
ctx=this,
fn=__annotator(function(){
if(callback.apply(callback,arguments)){
ctx.unsubscribe(name,fn);}},{'module':'sdk.Event','line':126,'column':13,'endLine':130,'endColumn':9});



this.subscribe(name,fn);}},{params:[[name,'string','name'],[callback,'function','callback']]});},{'module':'sdk.Event','line':122,'column':11,'endLine':134,'endColumn':3},{params:['string','function']}),












clear:__annotator(function(name){return __bodyWrapper(this,arguments,function(){
delete this.subscribers()[name];},{params:[[name,'string','name']]});},{'module':'sdk.Event','line':145,'column':9,'endLine':147,'endColumn':3},{params:['string']}),








fire:__annotator(function(name){return __bodyWrapper(this,arguments,function(){
var
args=Array.prototype.slice.call(arguments,1),
subs=this.subscribers()[name];

if(subs){
ES(subs,'forEach',true,__annotator(function(sub){


if(sub){
sub.apply(this,args);}},{'module':'sdk.Event','line':161,'column':19,'endLine':167,'endColumn':7}));}},{params:[[name,'string','name']]});},{'module':'sdk.Event','line':155,'column':8,'endLine':169,'endColumn':3},{params:['string']})};






module.exports = Event;},{'module':'sdk.Event','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Event'}),null);

__d('JSONRPC',['Log'],__annotator(function $module_JSONRPC(global,require,requireDynamic,requireLazy,module,exports,Log){if(require.__markCompiled)require.__markCompiled();





function JSONRPC(write){return __bodyWrapper(this,arguments,function(){'use strict';
this.$JSONRPC_counter = 0;
this.$JSONRPC_callbacks = {};

this.remote = ES(__annotator(function(context){
this.$JSONRPC_context = context;
return this.remote;},{'module':'JSONRPC','line':86,'column':18,'endLine':89,'endColumn':5}),'bind',true,this);


this.local = {};

this.$JSONRPC_write = write;},{params:[[write,'function','write']]});}__annotator(JSONRPC,{'module':'JSONRPC','line':82,'column':2,'endLine':94,'endColumn':3,'name':'JSONRPC'},{params:['function']});JSONRPC.prototype.











stub = __annotator(function(stub){return __bodyWrapper(this,arguments,function(){'use strict';
this.remote[stub] = ES(__annotator(function(){
var message={
jsonrpc:'2.0',
method:stub};for(var _len=arguments.length,args=Array(_len),_key=0;_key < _len;_key++) {args[_key] = arguments[_key];}


if(typeof args[args.length - 1] == 'function'){
message.id = ++this.$JSONRPC_counter;
this.$JSONRPC_callbacks[message.id] = args.pop();}


message.params = args;

this.$JSONRPC_write(ES('JSON','stringify',false,message),this.$JSONRPC_context || {method:stub});},{'module':'JSONRPC','line':106,'column':24,'endLine':120,'endColumn':5}),'bind',true,this);},{params:[[stub,'string','stub']]});},{'module':'JSONRPC','line':105,'column':6,'endLine':121,'endColumn':3},{params:['string']});JSONRPC.prototype.













read = __annotator(function(message,context){return __bodyWrapper(this,arguments,function(){'use strict';
var rpc=ES('JSON','parse',false,message),id=rpc.id;

if(!rpc.method){

if(!this.$JSONRPC_callbacks[id]){
Log.warn('Could not find callback %s',id);
return;}

var callback=this.$JSONRPC_callbacks[id];
delete this.$JSONRPC_callbacks[id];

delete rpc.id;
delete rpc.jsonrpc;

callback(rpc);
return;}



var instance=this,method=this.local[rpc.method],send;
if(id){

send = __annotator(function(type,value){return __bodyWrapper(this,arguments,function(){
var response={
jsonrpc:'2.0',
id:id};

response[type] = value;



setTimeout(__annotator(function(){
instance.$JSONRPC_write(ES('JSON','stringify',false,response),context);},{'module':'JSONRPC','line':165,'column':19,'endLine':167,'endColumn':9}),
0);},{params:[[type,'string','type']]});},{'module':'JSONRPC','line':156,'column':13,'endLine':168,'endColumn':7},{params:['string']});}else

{

send = __annotator(function(){},{'module':'JSONRPC','line':171,'column':13,'endLine':171,'endColumn':26});}


if(!method){
Log.error('Method "%s" has not been defined',rpc.method);

send('error',{
code:-32601,
message:'Method not found',
data:rpc.method});

return;}



rpc.params.push(ES(send,'bind',true,null,'result'));
rpc.params.push(ES(send,'bind',true,null,'error'));


try{
var returnValue=method.apply(context || null,rpc.params);

if(typeof returnValue !== 'undefined'){
send('result',returnValue);}}

catch(rpcEx) {
Log.error('Invokation of RPC method %s resulted in the error: %s',
rpc.method,rpcEx.message);

send('error',{
code:-32603,
message:'Internal error',
data:rpcEx.message});}},{params:[[message,'string','message']]});},{'module':'JSONRPC','line':133,'column':6,'endLine':206,'endColumn':3},{params:['string']});





module.exports = JSONRPC;},{'module':'JSONRPC','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_JSONRPC'}),null);

__d('sdk.RPC',['Assert','JSONRPC','Queue'],__annotator(function $module_sdk_RPC(global,require,requireDynamic,requireLazy,module,exports,Assert,JSONRPC,Queue){if(require.__markCompiled)require.__markCompiled();





var outQueue=new Queue();
var jsonrpc=new JSONRPC(__annotator(function(message){return __bodyWrapper(this,arguments,function(){
outQueue.enqueue(message);},{params:[[message,'string','message']]});},{'module':'sdk.RPC','line':13,'column':26,'endLine':15,'endColumn':1},{params:['string']}));


var RPC={
local:jsonrpc.local,
remote:jsonrpc.remote,
stub:ES(jsonrpc.stub,'bind',true,jsonrpc),
setInQueue:__annotator(function(queue){return __bodyWrapper(this,arguments,function(){
Assert.isInstanceOf(Queue,queue);

queue.start(__annotator(function(message){return __bodyWrapper(this,arguments,function(){
jsonrpc.read(message);},{params:[[message,'string','message']]});},{'module':'sdk.RPC','line':24,'column':16,'endLine':26,'endColumn':5},{params:['string']}));},{params:[[queue,'object','queue']]});},{'module':'sdk.RPC','line':21,'column':14,'endLine':27,'endColumn':3},{params:['object']}),


getOutQueue:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return outQueue;},{returns:'object'});},{'module':'sdk.RPC','line':28,'column':15,'endLine':30,'endColumn':3},{returns:'object'})};



module.exports = RPC;},{'module':'sdk.RPC','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_RPC'}),null);

__d('sdk.Scribe',['QueryString','sdk.Runtime','UrlMap'],__annotator(function $module_sdk_Scribe(global,require,requireDynamic,requireLazy,module,exports,QueryString,Runtime,UrlMap){if(require.__markCompiled)require.__markCompiled();




function log(category,data){return __bodyWrapper(this,arguments,function(){
if(typeof data.extra == 'object'){
data.extra.revision = Runtime.getRevision();}

new Image().src = QueryString.appendToUrl(
UrlMap.resolve('www',true) + '/common/scribe_endpoint.php',
{
c:category,
m:ES('JSON','stringify',false,data)});},{params:[[category,'string','category'],[data,'object','data']]});}__annotator(log,{'module':'sdk.Scribe','line':11,'column':0,'endLine':22,'endColumn':1,'name':'log'},{params:['string','object']});




var Scribe={
log:log};


module.exports = Scribe;},{'module':'sdk.Scribe','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Scribe'}),null);

__d('hasNamePropertyBug',['guid','UserAgent_DEPRECATED'],__annotator(function $module_hasNamePropertyBug(global,require,requireDynamic,requireLazy,module,exports,guid,UserAgent_DEPRECATED){if(require.__markCompiled)require.__markCompiled();




var hasBug=UserAgent_DEPRECATED.ie()?undefined:false;




function test(){return __bodyWrapper(this,arguments,function(){
var form=document.createElement("form"),
input=form.appendChild(document.createElement("input"));
input.name = guid();
hasBug = input !== form.elements[input.name];
form = input = null;
return hasBug;},{returns:'boolean'});}__annotator(test,{'module':'hasNamePropertyBug','line':16,'column':0,'endLine':23,'endColumn':1,'name':'test'},{returns:'boolean'});


function hasNamePropertyBug(){return __bodyWrapper(this,arguments,function(){
return typeof hasBug === 'undefined'?
test():
hasBug;},{returns:'boolean'});}__annotator(hasNamePropertyBug,{'module':'hasNamePropertyBug','line':25,'column':0,'endLine':29,'endColumn':1,'name':'hasNamePropertyBug'},{returns:'boolean'});


module.exports = hasNamePropertyBug;},{'module':'hasNamePropertyBug','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_hasNamePropertyBug'}),null);

__d('sdk.createIframe',['DOMEventListener','getBlankIframeSrc','guid','hasNamePropertyBug'],__annotator(function $module_sdk_createIframe(global,require,requireDynamic,requireLazy,module,exports,DOMEventListener,getBlankIframeSrc,guid,hasNamePropertyBug){if(require.__markCompiled)require.__markCompiled();







function createIframe(opts){return __bodyWrapper(this,arguments,function(){
opts = ES('Object','assign',false,{},opts);
var frame;
var name=opts.name || guid();
var root=opts.root;
var style=opts.style || {border:'none'};
var src=opts.url;
var onLoad=opts.onload;
var onError=opts.onerror;

if(hasNamePropertyBug()){
frame = document.createElement('<iframe name="' + name + '"/>');}else
{
frame = document.createElement("iframe");
frame.name = name;}



delete opts.style;
delete opts.name;
delete opts.url;
delete opts.root;
delete opts.onload;
delete opts.onerror;

var attributes=ES('Object','assign',false,{
frameBorder:0,
allowTransparency:true,
allowFullscreen:true,
scrolling:'no'},
opts);


if(attributes.width){
frame.width = attributes.width + 'px';}

if(attributes.height){
frame.height = attributes.height + 'px';}


delete attributes.height;
delete attributes.width;

for(var key in attributes) {
if(attributes.hasOwnProperty(key)){
frame.setAttribute(key,attributes[key]);}}



ES('Object','assign',false,frame.style,style);



frame.src = getBlankIframeSrc();
root.appendChild(frame);
if(onLoad){
var onLoadListener=DOMEventListener.add(frame,'load',__annotator(function(){
onLoadListener.remove();
onLoad();},{'module':'sdk.createIframe','line':72,'column':61,'endLine':75,'endColumn':5}));}



if(onError){
var onErrorListener=DOMEventListener.add(frame,'error',__annotator(function(){
onErrorListener.remove();
onError();},{'module':'sdk.createIframe','line':79,'column':63,'endLine':82,'endColumn':5}));}





frame.src = src;
return frame;},{params:[[opts,'object','opts']],returns:'HTMLElement'});}__annotator(createIframe,{'module':'sdk.createIframe','line':16,'column':0,'endLine':89,'endColumn':1,'name':'createIframe'},{params:['object'],returns:'HTMLElement'});


module.exports = createIframe;},{'module':'sdk.createIframe','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_createIframe'}),null);

__d('sdk.feature',['JSSDKConfig','invariant'],__annotator(function $module_sdk_feature(global,require,requireDynamic,requireLazy,module,exports,SDKConfig,invariant){if(require.__markCompiled)require.__markCompiled();












function feature(name,defaultValue){return __bodyWrapper(this,arguments,function(){
!(
arguments.length >= 2)?invariant(0,
'Default value is required'):undefined;

if(SDKConfig.features && name in SDKConfig.features){
var value=SDKConfig.features[name];
if(typeof value === 'object' && typeof value.rate === 'number'){
if(value.rate && Math.random() * 100 <= value.rate){
return value.value || true;}else
{
return value.value?null:false;}}else

{
return value;}}


return defaultValue;},{params:[[name,'string','name']]});}__annotator(feature,{'module':'sdk.feature','line':20,'column':0,'endLine':38,'endColumn':1,'name':'feature'},{params:['string']});


module.exports = feature;},{'module':'sdk.feature','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_feature'}),null);

__d('sdk.XD',['sdk.Content','sdk.Event','Log','QueryString','Queue','sdk.RPC','sdk.Runtime','sdk.Scribe','sdk.URI','UrlMap','JSSDKXDConfig','XDM','isFacebookURI','sdk.createIframe','sdk.feature','guid'],__annotator(function $module_sdk_XD(global,require,requireDynamic,requireLazy,module,exports,Content,Event,Log,QueryString,Queue,RPC,Runtime,Scribe,URI,UrlMap,XDConfig,XDM,isFacebookURI,createIframe,feature,guid){if(require.__markCompiled)require.__markCompiled();



















var facebookQueue=new Queue();
var httpProxyQueue=new Queue();
var httpsProxyQueue=new Queue();
var httpProxyFrame;
var httpsProxyFrame;
var proxySecret=guid();

var xdArbiterTier=XDConfig.useCdn?'cdn':'www';
var xdArbiterPathAndQuery=feature('use_bundle',false)?
XDConfig.XdBundleUrl:
XDConfig.XdUrl;
var xdArbiterHttpUrl=
UrlMap.resolve(xdArbiterTier,false) + xdArbiterPathAndQuery;
var xdArbiterHttpsUrl=
UrlMap.resolve(xdArbiterTier,true) + xdArbiterPathAndQuery;

var channel=guid();
var origin=location.protocol + '//' + location.host;
var xdm;
var inited=false;
var IFRAME_TITLE='Facebook Cross Domain Communication Frame';

var pluginRegistry={};
var rpcQueue=new Queue();
RPC.setInQueue(rpcQueue);

function onRegister(registeredAs){return __bodyWrapper(this,arguments,function(){
Log.info('Remote XD can talk to facebook.com (%s)',registeredAs);
Runtime.setEnvironment(
registeredAs === 'canvas'?
Runtime.ENVIRONMENTS.CANVAS:
Runtime.ENVIRONMENTS.PAGETAB);},{params:[[registeredAs,'string','registeredAs']]});}__annotator(onRegister,{'module':'sdk.XD','line':52,'column':0,'endLine':58,'endColumn':1,'name':'onRegister'},{params:['string']});


function handleAction(message,senderOrigin){return __bodyWrapper(this,arguments,function(){
if(!senderOrigin){
Log.error('No senderOrigin');
throw new Error();}


var protocol=/^https?/.exec(senderOrigin)[0];

switch(message.xd_action){
case 'proxy_ready':
var proxyQueue;
var targetProxyFrame;

if(protocol == 'https'){
proxyQueue = httpsProxyQueue;
targetProxyFrame = httpsProxyFrame;
Runtime.setLoggedIntoFacebook(message.logged_in === 'true');}else
{
proxyQueue = httpProxyQueue;
targetProxyFrame = httpProxyFrame;}


if(message.registered){
onRegister(message.registered);
facebookQueue = proxyQueue.merge(facebookQueue);}


Log.info('Proxy ready, starting queue %s containing %s messages',
protocol + 'ProxyQueue',proxyQueue.getLength());

proxyQueue.start(__annotator(function(message){return __bodyWrapper(this,arguments,function(){
xdm.send(
typeof message === 'string'?message:QueryString.encode(message),
senderOrigin,
targetProxyFrame.contentWindow,
channel + '_' + protocol);},{params:[[message,'string|object','message']]});},{'module':'sdk.XD','line':90,'column':23,'endLine':97,'endColumn':7},{params:['string|object']}));


break;

case 'plugin_ready':
Log.info('Plugin %s ready, protocol: %s',message.name,protocol);
pluginRegistry[message.name] = {protocol:protocol};
if(Queue.exists(message.name)){
var queue=Queue.get(message.name);
Log.debug('Enqueuing %s messages for %s in %s',queue.getLength(),
message.name,protocol + 'ProxyQueue');

(protocol == 'https'?httpsProxyQueue:httpProxyQueue).merge(queue);}

break;}



if(message.data){
onMessage(message.data,senderOrigin);}},{params:[[message,'object','message'],[senderOrigin,'string','senderOrigin']]});}__annotator(handleAction,{'module':'sdk.XD','line':60,'column':0,'endLine':117,'endColumn':1,'name':'handleAction'},{params:['object','string']});






function onMessage(message,senderOrigin){return __bodyWrapper(this,arguments,function(){
if(senderOrigin && senderOrigin !== 'native' &&
!isFacebookURI(new URI(senderOrigin))){
return;}

if(typeof message == 'string'){
if(/^FB_RPC:/.test(message)){
rpcQueue.enqueue(message.substring(7));
return;}


if(message.substring(0,1) == '{'){
try{
message = ES('JSON','parse',false,message);}
catch(decodeException) {
Log.warn('Failed to decode %s as JSON',message);
return;}}else

{
message = QueryString.decode(message);}}




if(!senderOrigin){

if(message.xd_sig == proxySecret){
senderOrigin = message.xd_origin;}}



if(message.xd_action){
handleAction(message,senderOrigin);
return;}




if(message.access_token){
Runtime.setSecure(/^https/.test(origin));}



if(message.cb){
var cb=XD._callbacks[message.cb];
if(!XD._forever[message.cb]){
delete XD._callbacks[message.cb];}

if(cb){
cb(message);}}},{params:[[message,'string|object','message'],[senderOrigin,'?string','senderOrigin']]});}__annotator(onMessage,{'module':'sdk.XD','line':122,'column':0,'endLine':174,'endColumn':1,'name':'onMessage'},{params:['string|object','?string']});




function sendToFacebook(recipient,message){return __bodyWrapper(this,arguments,function(){
if(recipient == 'facebook'){
message.relation = 'parent.parent';
facebookQueue.enqueue(message);}else
{
message.relation = 'parent.frames["' + recipient + '"]';
var regInfo=pluginRegistry[recipient];
if(regInfo){
Log.debug('Enqueuing message for plugin %s in %s',
recipient,regInfo.protocol + 'ProxyQueue');

(regInfo.protocol == 'https'?httpsProxyQueue:httpProxyQueue).
enqueue(message);}else
{
Log.debug('Buffering message for plugin %s',recipient);
Queue.get(recipient).enqueue(message);}}},{params:[[recipient,'string','recipient'],[message,'object|string','message']]});}__annotator(sendToFacebook,{'module':'sdk.XD','line':176,'column':0,'endLine':194,'endColumn':1,'name':'sendToFacebook'},{params:['string','object|string']});





RPC.getOutQueue().start(__annotator(function(message){return __bodyWrapper(this,arguments,function(){
sendToFacebook('facebook','FB_RPC:' + message);},{params:[[message,'string','message']]});},{'module':'sdk.XD','line':197,'column':24,'endLine':199,'endColumn':1},{params:['string']}));


function init(xdProxyName){return __bodyWrapper(this,arguments,function(){
if(inited){
return;}



var container=Content.appendHidden(document.createElement('div'));


var transport=XDM.create({
blacklist:null,
root:container,
channel:channel,
flashUrl:XDConfig.Flash.path,
whenReady:__annotator(function(instance){return __bodyWrapper(this,arguments,function(){
xdm = instance;

var proxyData={
channel:channel,
origin:location.protocol + '//' + location.host,
transport:transport,
xd_name:xdProxyName};


var xdArbiterFragment='#' + QueryString.encode(proxyData);






if(Runtime.getSecure() !== true){


httpProxyFrame = createIframe({
url:xdArbiterHttpUrl + xdArbiterFragment,
name:'fb_xdm_frame_http',
id:'fb_xdm_frame_http',
root:container,
'aria-hidden':true,
title:IFRAME_TITLE,
tabindex:-1});}





httpsProxyFrame = createIframe({
url:xdArbiterHttpsUrl + xdArbiterFragment,
name:'fb_xdm_frame_https',
id:'fb_xdm_frame_https',
root:container,
'aria-hidden':true,
title:IFRAME_TITLE,
tabindex:-1});},{params:[[instance,'object','instance']]});},{'module':'sdk.XD','line':215,'column':15,'endLine':257,'endColumn':5},{params:['object']}),


onMessage:onMessage});

if(!transport){
Scribe.log('jssdk_error',{
appId:Runtime.getClientID(),
error:'XD_TRANSPORT',
extra:{
message:'Failed to create a valid transport'}});}



inited = true;},{params:[[xdProxyName,'?string','xdProxyName']]});}__annotator(init,{'module':'sdk.XD','line':201,'column':0,'endLine':270,'endColumn':1,'name':'init'},{params:['?string']});








var XD={


rpc:RPC,

_callbacks:{},
_forever:{},
_channel:channel,
_origin:origin,

onMessage:onMessage,
recv:onMessage,







init:init,









sendToFacebook:sendToFacebook,





inform:__annotator(function(method,params,relation,
behavior){return __bodyWrapper(this,arguments,function(){
sendToFacebook('facebook',{
method:method,
params:ES('JSON','stringify',false,params || {}),
behavior:behavior || 'p',
relation:relation});},{params:[[method,'string','method'],[params,'?object','params'],[relation,'?string','relation'],[behavior,'?string','behavior']]});},{'module':'sdk.XD','line':313,'column':10,'endLine':321,'endColumn':3},{params:['string','?object','?string','?string']}),

















handler:__annotator(function(cb,relation,forever,
id){return __bodyWrapper(this,arguments,function(){
var xdArbiterFragment='#' + QueryString.encode({
cb:this.registerCallback(cb,forever,id),
origin:origin + '/' + channel,
domain:location.hostname,
relation:relation || 'opener'});

return (location.protocol == 'https:'?
xdArbiterHttpsUrl:
xdArbiterHttpUrl) +
xdArbiterFragment;},{params:[[cb,'function','cb'],[relation,'?string','relation'],[forever,'?boolean','forever'],[id,'?string','id']],returns:'string'});},{'module':'sdk.XD','line':337,'column':11,'endLine':349,'endColumn':3},{params:['function','?string','?boolean','?string'],returns:'string'}),


registerCallback:__annotator(function(cb,persistent,
id){return __bodyWrapper(this,arguments,function(){
id = id || guid();
if(persistent){
XD._forever[id] = true;}

XD._callbacks[id] = cb;
return id;},{params:[[cb,'function','cb'],[persistent,'?boolean','persistent'],[id,'?string','id']],returns:'string'});},{'module':'sdk.XD','line':351,'column':20,'endLine':359,'endColumn':3},{params:['function','?boolean','?string'],returns:'string'})};







Event.subscribe('init:post',__annotator(function(options){return __bodyWrapper(this,arguments,function(){
init(options.xdProxyName);
var timeout=feature('xd_timeout',false);
if(timeout){
setTimeout(__annotator(function(){
var initialized=
httpsProxyFrame && (
!!httpProxyFrame == httpProxyQueue.isStarted() &&
!!httpsProxyFrame == httpsProxyQueue.isStarted());

if(!initialized){
Scribe.log('jssdk_error',{
appId:Runtime.getClientID(),
error:'XD_INITIALIZATION',
extra:{
message:'Failed to initialize in ' + timeout + 'ms'}});}},{'module':'sdk.XD','line':370,'column':15,'endLine':385,'endColumn':5}),



timeout);}},{params:[[options,'object','options']]});},{'module':'sdk.XD','line':366,'column':29,'endLine':387,'endColumn':1},{params:['object']}));




module.exports = XD;},{'module':'sdk.XD','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XD'}),null);

__d('sdk.getContextType',['sdk.Runtime','sdk.UA'],__annotator(function $module_sdk_getContextType(global,require,requireDynamic,requireLazy,module,exports,Runtime,UA){if(require.__markCompiled)require.__markCompiled();




function getContextType(){return __bodyWrapper(this,arguments,function(){






if(UA.nativeApp()){
return 3;}

if(UA.mobile()){
return 2;}

if(Runtime.isEnvironment(Runtime.ENVIRONMENTS.CANVAS)){
return 5;}

return 1;},{returns:'number'});}__annotator(getContextType,{'module':'sdk.getContextType','line':11,'column':0,'endLine':28,'endColumn':1,'name':'getContextType'},{returns:'number'});


module.exports = getContextType;},{'module':'sdk.getContextType','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_getContextType'}),null);

__d('sdk.Auth',['sdk.Cookie','sdk.createIframe','DOMWrapper','sdk.feature','sdk.getContextType','guid','sdk.Impressions','Log','ObservableMixin','sdk.Runtime','sdk.SignedRequest','UrlMap','sdk.URI','sdk.XD'],__annotator(function $module_sdk_Auth(global,require,requireDynamic,requireLazy,module,exports,Cookie,createIframe,DOMWrapper,feature,getContextType,guid,Impressions,Log,ObservableMixin,Runtime,SignedRequest,UrlMap,URI,XD){if(require.__markCompiled)require.__markCompiled();
















var LOGOUT_COOKIE_PREFIX='fblo_';
var YEAR_MS=365 * 24 * 60 * 60 * 1000;

var currentAuthResponse;

var timer;

var Auth=new ObservableMixin();

function setAuthResponse(authResponse,status){return __bodyWrapper(this,arguments,function(){
var currentUserID=Runtime.getUserID();
var userID='';
if(authResponse){




if(authResponse.userID){
userID = authResponse.userID;}else
if(authResponse.signedRequest){
var parsedSignedRequest=
SignedRequest.parse(authResponse.signedRequest);
if(parsedSignedRequest && parsedSignedRequest.user_id){
userID = parsedSignedRequest.user_id;}}}




var
currentStatus=Runtime.getLoginStatus(),
login=currentStatus === 'unknown' && authResponse ||
Runtime.getUseCookie() && Runtime.getCookieUserID() !== userID,
logout=currentUserID && !authResponse,
both=authResponse && currentUserID && currentUserID != userID,
authResponseChange=authResponse != currentAuthResponse,
statusChange=status != (currentStatus || 'unknown');



Runtime.setLoginStatus(status);
Runtime.setAccessToken(authResponse && authResponse.accessToken || null);
Runtime.setUserID(userID);

currentAuthResponse = authResponse;

var response={
authResponse:authResponse,
status:status};


if(logout || both){
Auth.inform('logout',response);}

if(login || both){
Auth.inform('login',response);}

if(authResponseChange){
Auth.inform('authresponse.change',response);}

if(statusChange){
Auth.inform('status.change',response);}

return response;},{params:[[authResponse,'?object','authResponse'],[status,'string','status']]});}__annotator(setAuthResponse,{'module':'sdk.Auth','line':32,'column':0,'endLine':86,'endColumn':1,'name':'setAuthResponse'},{params:['?object','string']});


function getAuthResponse(){return __bodyWrapper(this,arguments,function(){
return currentAuthResponse;},{returns:'?object'});}__annotator(getAuthResponse,{'module':'sdk.Auth','line':88,'column':0,'endLine':90,'endColumn':1,'name':'getAuthResponse'},{returns:'?object'});


function xdResponseWrapper(cb,authResponse,
method){return __bodyWrapper(this,arguments,function(){
return __annotator(function(params){return __bodyWrapper(this,arguments,function(){
var status;

if(params && params.access_token){

var parsedSignedRequest=SignedRequest.parse(params.signed_request);
authResponse = {
accessToken:params.access_token,
userID:parsedSignedRequest.user_id,
expiresIn:parseInt(params.expires_in,10),
signedRequest:params.signed_request};


if(params.granted_scopes){
authResponse.grantedScopes = params.granted_scopes;}


if(Runtime.getUseCookie()){
var expirationTime=authResponse.expiresIn === 0?
0:
ES('Date','now',false) + authResponse.expiresIn * 1000;
var baseDomain=Cookie.getDomain();
if(!baseDomain && params.base_domain){




Cookie.setDomain('.' + params.base_domain);}

Cookie.setSignedRequestCookie(params.signed_request,
expirationTime);
Cookie.setRaw(LOGOUT_COOKIE_PREFIX,'',0);}

status = 'connected';
setAuthResponse(authResponse,status);}else
if(method === 'logout' || method === 'login_status'){




if(params.error && params.error === 'not_authorized'){
status = 'not_authorized';}else
{
status = 'unknown';}

setAuthResponse(null,status);
if(Runtime.getUseCookie()){
Cookie.clearSignedRequestCookie();}

if(method === 'logout'){
Cookie.setRaw(
LOGOUT_COOKIE_PREFIX,
'y',
ES('Date','now',false) + YEAR_MS);}}




if(params && params.https == 1){
Runtime.setSecure(true);}


if(cb){
cb({
authResponse:authResponse,
status:Runtime.getLoginStatus()});}


return authResponse;},{returns:'?object'});},{'module':'sdk.Auth','line':94,'column':9,'endLine':163,'endColumn':3},{returns:'?object'});},{params:[[cb,'function','cb'],[authResponse,'?object','authResponse'],[method,'?string','method']],returns:'function'});}__annotator(xdResponseWrapper,{'module':'sdk.Auth','line':92,'column':0,'endLine':164,'endColumn':1,'name':'xdResponseWrapper'},{params:['function','?object','?string'],returns:'function'});



function fetchLoginStatus(fn){return __bodyWrapper(this,arguments,function(){
var frame,fetchStart=ES('Date','now',false);

if(timer){
clearTimeout(timer);
timer = null;}


if(Cookie.getRaw(LOGOUT_COOKIE_PREFIX) === 'y'){




var unk_status='unknown';
setAuthResponse(null,unk_status);
if(fn){
fn({
authResponse:null,
status:unk_status});}


return;}


var handleResponse=xdResponseWrapper(fn,currentAuthResponse,
'login_status');

var url=new URI(UrlMap.resolve('www',true) + '/connect/ping').
setQueryData({
client_id:Runtime.getClientID(),
response_type:'token,signed_request,code',
domain:location.hostname,
origin:getContextType(),
redirect_uri:XD.handler(__annotator(function(response){return __bodyWrapper(this,arguments,function(){
if(feature('e2e_ping_tracking',true)){
var events={
init:fetchStart,
close:ES('Date','now',false),
method:'ping'};

Log.debug('e2e: %s',ES('JSON','stringify',false,events));

Impressions.log(114,{
payload:events});}


frame.parentNode.removeChild(frame);
if(handleResponse(response)){

timer = setTimeout(__annotator(function(){
fetchLoginStatus(__annotator(function(){},{'module':'sdk.Auth','line':216,'column':29,'endLine':216,'endColumn':42}));},{'module':'sdk.Auth','line':215,'column':29,'endLine':217,'endColumn':11}),
1200000);}},{params:[[response,'object','response']]});},{'module':'sdk.Auth','line':199,'column':31,'endLine':219,'endColumn':7},{params:['object']}),

'parent'),
sdk:'joey',
kid_directed_site:Runtime.getKidDirectedSite()});


frame = createIframe({
root:DOMWrapper.getRoot(),
name:guid(),
url:url.toString(),
style:{display:'none'}});},{params:[[fn,'function','fn']]});}__annotator(fetchLoginStatus,{'module':'sdk.Auth','line':166,'column':0,'endLine':231,'endColumn':1,'name':'fetchLoginStatus'},{params:['function']});




var loadState;
function getLoginStatus(cb,force){return __bodyWrapper(this,arguments,function(){
if(!Runtime.getClientID()){
Log.warn('FB.getLoginStatus() called before calling FB.init().');
return;}




if(cb){
if(!force && loadState == 'loaded'){
cb({status:Runtime.getLoginStatus(),
authResponse:getAuthResponse()});
return;}else
{
Auth.subscribe('FB.loginStatus',cb);}}




if(!force && loadState == 'loading'){
return;}


loadState = 'loading';


var lsCb=__annotator(function(response){return __bodyWrapper(this,arguments,function(){

loadState = 'loaded';


Auth.inform('FB.loginStatus',response);
Auth.clearSubscribers('FB.loginStatus');},{params:[[response,'?object','response']]});},{'module':'sdk.Auth','line':260,'column':13,'endLine':267,'endColumn':3},{params:['?object']});


fetchLoginStatus(lsCb);},{params:[[cb,'?function','cb'],[force,'?boolean','force']]});}__annotator(getLoginStatus,{'module':'sdk.Auth','line':234,'column':0,'endLine':270,'endColumn':1,'name':'getLoginStatus'},{params:['?function','?boolean']});


ES('Object','assign',false,Auth,{
getLoginStatus:getLoginStatus,
fetchLoginStatus:fetchLoginStatus,
setAuthResponse:setAuthResponse,
getAuthResponse:getAuthResponse,
parseSignedRequest:SignedRequest.parse,

xdResponseWrapper:xdResponseWrapper});


module.exports = Auth;},{'module':'sdk.Auth','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Auth'}),null);

__d('sdk.DOM',['Assert','sdk.UA','sdk.domReady'],__annotator(function $module_sdk_DOM(global,require,requireDynamic,requireLazy,module,exports,Assert,UA,domReady){if(require.__markCompiled)require.__markCompiled();






var cssRules={};

function getAttr(dom,name){return __bodyWrapper(this,arguments,function(){
var attribute=
dom.getAttribute(name) ||
dom.getAttribute(name.replace(/_/g,'-')) ||
dom.getAttribute(name.replace(/-/g,'_')) ||
dom.getAttribute(name.replace(/-/g,'')) ||
dom.getAttribute(name.replace(/_/g,'')) ||
dom.getAttribute('data-' + name) ||
dom.getAttribute('data-' + name.replace(/_/g,'-')) ||
dom.getAttribute('data-' + name.replace(/-/g,'_')) ||
dom.getAttribute('data-' + name.replace(/-/g,'')) ||
dom.getAttribute('data-' + name.replace(/_/g,''));

return attribute?
String(attribute):
null;},{params:[[dom,'HTMLElement','dom'],[name,'string','name']],returns:'?string'});}__annotator(getAttr,{'module':'sdk.DOM','line':15,'column':0,'endLine':31,'endColumn':1,'name':'getAttr'},{params:['HTMLElement','string'],returns:'?string'});


function getBoolAttr(dom,name){return __bodyWrapper(this,arguments,function(){
var attribute=getAttr(dom,name);
return attribute?
/^(true|1|yes|on)$/.test(attribute):
null;},{params:[[dom,'HTMLElement','dom'],[name,'string','name']],returns:'?boolean'});}__annotator(getBoolAttr,{'module':'sdk.DOM','line':33,'column':0,'endLine':38,'endColumn':1,'name':'getBoolAttr'},{params:['HTMLElement','string'],returns:'?boolean'});


function getProp(dom,name){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(dom,'element not specified');
Assert.isString(name);

try{
return String(dom[name]);}
catch(e) {
throw new Error('Could not read property ' + name + ' : ' + e.message);}},{params:[[dom,'HTMLElement','dom'],[name,'string','name']],returns:'string'});}__annotator(getProp,{'module':'sdk.DOM','line':40,'column':0,'endLine':49,'endColumn':1,'name':'getProp'},{params:['HTMLElement','string'],returns:'string'});



function html(dom,content){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(dom,'element not specified');
Assert.isString(content);

try{
dom.innerHTML = content;}
catch(e) {
throw new Error('Could not set innerHTML : ' + e.message);}},{params:[[dom,'HTMLElement','dom'],[content,'string','content']]});}__annotator(html,{'module':'sdk.DOM','line':51,'column':0,'endLine':60,'endColumn':1,'name':'html'},{params:['HTMLElement','string']});






function hasClass(dom,className){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(dom,'element not specified');
Assert.isString(className);

var cssClassWithSpace=' ' + getProp(dom,'className') + ' ';
return ES(cssClassWithSpace,'indexOf',true,' ' + className + ' ') >= 0;},{params:[[dom,'HTMLElement','dom'],[className,'string','className']],returns:'boolean'});}__annotator(hasClass,{'module':'sdk.DOM','line':65,'column':0,'endLine':71,'endColumn':1,'name':'hasClass'},{params:['HTMLElement','string'],returns:'boolean'});





function addClass(dom,className){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(dom,'element not specified');
Assert.isString(className);

if(!hasClass(dom,className)){
dom.className = getProp(dom,'className') + ' ' + className;}},{params:[[dom,'HTMLElement','dom'],[className,'string','className']]});}__annotator(addClass,{'module':'sdk.DOM','line':76,'column':0,'endLine':83,'endColumn':1,'name':'addClass'},{params:['HTMLElement','string']});






function removeClass(dom,className){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(dom,'element not specified');
Assert.isString(className);

var regExp=new RegExp('\\s*' + className,'g');
dom.className = ES(getProp(dom,'className').replace(regExp,''),'trim',true);},{params:[[dom,'HTMLElement','dom'],[className,'string','className']]});}__annotator(removeClass,{'module':'sdk.DOM','line':88,'column':0,'endLine':94,'endColumn':1,'name':'removeClass'},{params:['HTMLElement','string']});








function getByClass(className,dom,tagName){return __bodyWrapper(this,arguments,function(){
Assert.isString(className);

dom = dom || document.body;
tagName = tagName || '*';
if(dom.querySelectorAll){
return ES('Array','from',false,
dom.querySelectorAll(tagName + '.' + className));}


var all=dom.getElementsByTagName(tagName),
els=[];
for(var i=0,len=all.length;i < len;i++) {
if(hasClass(all[i],className)){
els[els.length] = all[i];}}


return els;},{params:[[className,'string','className']],returns:'array<HTMLElement>'});}__annotator(getByClass,{'module':'sdk.DOM','line':102,'column':0,'endLine':120,'endColumn':1,'name':'getByClass'},{params:['string'],returns:'array<HTMLElement>'});










function getStyle(dom,styleProp){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(dom,'element not specified');
Assert.isString(styleProp);


styleProp = styleProp.replace(/-(\w)/g,__annotator(function(m,g1){
return g1.toUpperCase();},{'module':'sdk.DOM','line':135,'column':42,'endLine':137,'endColumn':3}));


var currentStyle=dom.currentStyle ||
document.defaultView.getComputedStyle(dom,null);

var computedStyle=currentStyle[styleProp];




if(/backgroundPosition?/.test(styleProp) &&
/top|left/.test(computedStyle)){
computedStyle = '0%';}

return computedStyle;},{params:[[dom,'HTMLElement','dom'],[styleProp,'string','styleProp']],returns:'string'});}__annotator(getStyle,{'module':'sdk.DOM','line':130,'column':0,'endLine':152,'endColumn':1,'name':'getStyle'},{params:['HTMLElement','string'],returns:'string'});








function setStyle(dom,styleProp,value){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(dom,'element not specified');
Assert.isString(styleProp);


styleProp = styleProp.replace(/-(\w)/g,__annotator(function(m,g1){
return g1.toUpperCase();},{'module':'sdk.DOM','line':165,'column':42,'endLine':167,'endColumn':3}));

dom.style[styleProp] = value;},{params:[[dom,'HTMLElement','dom'],[styleProp,'string','styleProp']]});}__annotator(setStyle,{'module':'sdk.DOM','line':160,'column':0,'endLine':169,'endColumn':1,'name':'setStyle'},{params:['HTMLElement','string']});





function addCssRules(styles,names){return __bodyWrapper(this,arguments,function(){


var allIncluded=true;
for(var i=0,id;id = names[i++];) {
if(!(id in cssRules)){
allIncluded = false;
cssRules[id] = true;}}



if(allIncluded){
return;}


if(UA.ie() < 11){
try{
document.createStyleSheet().cssText = styles;}
catch(exc) {



if(document.styleSheets[0]){
document.styleSheets[0].cssText += styles;}}}else


{
var style=document.createElement('style');
style.type = 'text/css';
style.textContent = styles;
document.getElementsByTagName('head')[0].appendChild(style);}},{params:[[styles,'string','styles'],[names,'array<string>','names']]});}__annotator(addCssRules,{'module':'sdk.DOM','line':174,'column':0,'endLine':206,'endColumn':1,'name':'addCssRules'},{params:['string','array<string>']});







function getViewportInfo(){return __bodyWrapper(this,arguments,function(){

var root=document.documentElement && document.compatMode == 'CSS1Compat'?
document.documentElement:
document.body;

return {

scrollTop:root.scrollTop || document.body.scrollTop,
scrollLeft:root.scrollLeft || document.body.scrollLeft,
width:window.innerWidth?window.innerWidth:root.clientWidth,
height:window.innerHeight?window.innerHeight:root.clientHeight};},{returns:'object'});}__annotator(getViewportInfo,{'module':'sdk.DOM','line':212,'column':0,'endLine':225,'endColumn':1,'name':'getViewportInfo'},{returns:'object'});







function getPosition(node){return __bodyWrapper(this,arguments,function(){
Assert.isTruthy(node,'element not specified');

var x=0,
y=0;
do {
x += node.offsetLeft;
y += node.offsetTop;}while(
node = node.offsetParent);

return {x:x,y:y};},{params:[[node,'HTMLElement','node']],returns:'object'});}__annotator(getPosition,{'module':'sdk.DOM','line':231,'column':0,'endLine':242,'endColumn':1,'name':'getPosition'},{params:['HTMLElement'],returns:'object'});



var DOM={
containsCss:hasClass,
addCss:addClass,
removeCss:removeClass,
getByClass:getByClass,

getStyle:getStyle,
setStyle:setStyle,

getAttr:getAttr,
getBoolAttr:getBoolAttr,
getProp:getProp,

html:html,

addCssRules:addCssRules,

getViewportInfo:getViewportInfo,
getPosition:getPosition,

ready:domReady};


module.exports = DOM;},{'module':'sdk.DOM','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_DOM'}),null);

__d('sdk.ErrorHandling',['ManagedError','sdk.Runtime','sdk.Scribe','sdk.UA','sdk.feature','wrapFunction'],__annotator(function $module_sdk_ErrorHandling(global,require,requireDynamic,requireLazy,module,exports,ManagedError,Runtime,Scribe,UA,feature,wrapFunction){if(require.__markCompiled)require.__markCompiled();









var handleError=feature('error_handling',false);
var currentEntry='';

function errorHandler(error){return __bodyWrapper(this,arguments,function(){
var originalError=error._originalError;
delete error._originalError;
Scribe.log('jssdk_error',{
appId:Runtime.getClientID(),
error:error.name || error.message,
extra:error});



throw originalError;},{params:[[error,'object','error']]});}__annotator(errorHandler,{'module':'sdk.ErrorHandling','line':19,'column':0,'endLine':30,'endColumn':1,'name':'errorHandler'},{params:['object']});









function normalizeError(err){return __bodyWrapper(this,arguments,function(){
var info={
line:err.lineNumber || err.line,
message:err.message,
name:err.name,
script:err.fileName || err.sourceURL || err.script,
stack:err.stackTrace || err.stack};



info._originalError = err;





if(UA.chrome() && /([\w:\.\/]+\.js):(\d+)/.test(err.stack)){
info.script = RegExp.$1;
info.line = parseInt(RegExp.$2,10);}



for(var k in info) {
info[k] == null && delete info[k];}

return info;},{returns:'object'});}__annotator(normalizeError,{'module':'sdk.ErrorHandling','line':39,'column':0,'endLine':65,'endColumn':1,'name':'normalizeError'},{returns:'object'});


function guard(func,entry){return __bodyWrapper(this,arguments,function(){
return __annotator(function(){


if(!handleError){
return func.apply(this,arguments);}


try{
currentEntry = entry;
return func.apply(this,arguments);}
catch(error) {


if(error instanceof ManagedError){
throw error;}


var data=normalizeError(error);
data.entry = entry;


var sanitizedArgs=ES(Array.prototype.slice.call(arguments),'map',true,
__annotator(function(arg){
var type=Object.prototype.toString.call(arg);
return (/^\[object (String|Number|Boolean|Object|Date)\]$/.test(type)?
arg:
arg.toString());},{'module':'sdk.ErrorHandling','line':90,'column':13,'endLine':95,'endColumn':7}));


data.args = ES('JSON','stringify',false,sanitizedArgs).substring(0,200);
errorHandler(data);}finally
{
currentEntry = '';}},{'module':'sdk.ErrorHandling','line':68,'column':9,'endLine':102,'endColumn':3});},{params:[[func,'function','func'],[entry,'?string','entry']],returns:'function'});}__annotator(guard,{'module':'sdk.ErrorHandling','line':67,'column':0,'endLine':103,'endColumn':1,'name':'guard'},{params:['function','?string'],returns:'function'});




function unguard(func){return __bodyWrapper(this,arguments,function(){
if(!func.__wrapper){
func.__wrapper = __annotator(function(){
try{
return func.apply(this,arguments);}
catch(e) {

window.setTimeout(__annotator(function(){
throw e;},{'module':'sdk.ErrorHandling','line':112,'column':26,'endLine':114,'endColumn':9}),
0);
return false;}},{'module':'sdk.ErrorHandling','line':107,'column':21,'endLine':117,'endColumn':5});}



return func.__wrapper;},{params:[[func,'function','func']],returns:'function'});}__annotator(unguard,{'module':'sdk.ErrorHandling','line':105,'column':0,'endLine':120,'endColumn':1,'name':'unguard'},{params:['function'],returns:'function'});


function wrap(real,entry){
return __annotator(function(fn,delay){
var name=entry + ':' + (
currentEntry || '[global]') + ':' + (
fn.name ||
'[anonymous]' + (arguments.callee.caller.name?
'(' + arguments.callee.caller.name + ')':
''));
return real(wrapFunction(fn,'entry',name),delay);},{'module':'sdk.ErrorHandling','line':123,'column':9,'endLine':131,'endColumn':3});}__annotator(wrap,{'module':'sdk.ErrorHandling','line':122,'column':0,'endLine':132,'endColumn':1,'name':'wrap'});



if(handleError){

setTimeout = wrap(setTimeout,'setTimeout');
setInterval = wrap(setInterval,'setInterval');
wrapFunction.setWrapper(guard,'entry');}



var ErrorHandler={
guard:guard,
unguard:unguard};


module.exports = ErrorHandler;},{'module':'sdk.ErrorHandling','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_ErrorHandling'}),null);

__d('sdk.Insights',['sdk.Impressions'],__annotator(function $module_sdk_Insights(global,require,requireDynamic,requireLazy,module,exports,Impressions){if(require.__markCompiled)require.__markCompiled();



var Insights={
TYPE:{
NOTICE:'notice',
WARNING:'warn',
ERROR:'error'},

CATEGORY:{
DEPRECATED:'deprecated',
APIERROR:'apierror'},



log:__annotator(function(type,category,content){return __bodyWrapper(this,arguments,function(){
var payload={
source:'jssdk',
type:type,
category:category,
payload:content};


Impressions.log(
113,
payload);},{params:[[type,'string','type'],[category,'string','category'],[content,'string','content']]});},{'module':'sdk.Insights','line':22,'column':7,'endLine':34,'endColumn':3},{params:['string','string','string']}),



impression:Impressions.impression};


module.exports = Insights;},{'module':'sdk.Insights','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Insights'}),null);

__d('FB',['sdk.Auth','JSSDKCssConfig','dotAccess','sdk.domReady','sdk.DOM','sdk.ErrorHandling','sdk.Content','DOMWrapper','GlobalCallback','sdk.Insights','Log','sdk.Runtime','sdk.Scribe','JSSDKConfig'],__annotator(function $module_FB(global,require,requireDynamic,requireLazy,module,exports,Auth,CssConfig,dotAccess,domReady,DOM,ErrorHandling,Content,DOMWrapper,GlobalCallback,Insights,Log,Runtime,Scribe,SDKConfig){if(require.__markCompiled)require.__markCompiled();
















var externalInterface;
var apiWhitelist,apiWhitelistMode=dotAccess(SDKConfig,'api.mode');
var logged={};
externalInterface = window.FB = {};
var FB={};

if(__DEV__){
FB.require = require;
window._FB = FB;}





Log.level = __DEV__?3:0;


GlobalCallback.setPrefix('FB.__globalCallbacks');

var fbRoot=document.createElement('div');
DOMWrapper.setRoot(fbRoot);

domReady(__annotator(function(){
Log.info('domReady');
Content.appendHidden(fbRoot);
if(CssConfig.rules){
DOM.addCssRules(CssConfig.rules,CssConfig.components);}},{'module':'FB','line':52,'column':9,'endLine':58,'endColumn':1}));



Runtime.subscribe('AccessToken.change',__annotator(function(value){return __bodyWrapper(this,arguments,function(){
if(!value && Runtime.getLoginStatus() === 'connected'){


Auth.getLoginStatus(null,true);}},{params:[[value,'?string','value']]});},{'module':'FB','line':60,'column':40,'endLine':66,'endColumn':1},{params:['?string']}));





if(dotAccess(SDKConfig,'api.whitelist.length')){
apiWhitelist = {};
ES(SDKConfig.api.whitelist,'forEach',true,__annotator(function(key){return __bodyWrapper(this,arguments,function(){
apiWhitelist[key] = 1;},{params:[[key,'string','key']]});},{'module':'FB','line':72,'column':34,'endLine':74,'endColumn':3},{params:['string']}));}



function protect(fn,accessor,key,
context){return __bodyWrapper(this,arguments,function(){
var exportMode;
if(/^_/.test(key)){
exportMode = 'hide';}else
if(apiWhitelist && !apiWhitelist[accessor]){
exportMode = apiWhitelistMode;}


switch(exportMode){
case 'hide':
return;
case 'stub':
return __annotator(function(){
Log.warn('The method FB.%s has been removed from the JS SDK.',
accessor);},{'module':'FB','line':90,'column':13,'endLine':93,'endColumn':7});

default:
return ErrorHandling.guard(__annotator(function(){
if(exportMode === 'warn'){
Log.warn('The method FB.%s is not officially supported by ' +
'Facebook and access to it will soon be removed.',accessor);
if(!logged.hasOwnProperty(accessor)){
Insights.log(
Insights.TYPE.WARNING,
Insights.CATEGORY.DEPRECATED,
'FB.' + accessor);



Scribe.log('jssdk_error',{
appId:Runtime.getClientID(),
error:'Private method used',
extra:{args:accessor}});


logged[accessor] = true;}}



function unwrap(val){
if(ES('Array','isArray',false,val)){
return ES(val,'map',true,unwrap);}

if(val && typeof val === 'object' && val.__wrapped){

return val.__wrapped;}






return typeof val === 'function' && /^function/.test(val.toString())?
ErrorHandling.unguard(val):
val;}__annotator(unwrap,{'module':'FB','line':117,'column':8,'endLine':133,'endColumn':9,'name':'unwrap'});


var args=ES(Array.prototype.slice.call(arguments),'map',true,unwrap);

var result=fn.apply(context,args);
var facade;
var isPlainObject=true;

if(result && typeof result === 'object'){



facade = ES('Object','create',false,result);
facade.__wrapped = result;



for(var key in result) {
var property=result[key];
if(typeof property !== 'function' || key === 'constructor'){
continue;}

isPlainObject = false;
facade[key] = protect(property,accessor + ':' + key,key,result);}}



if(!isPlainObject){
return facade;}

return isPlainObject?
result:
facade;},{'module':'FB','line':95,'column':33,'endLine':166,'endColumn':7}),
accessor);}},{params:[[fn,'function','fn'],[accessor,'string','accessor'],[key,'string','key'],[context,'object','context']],returns:'?function'});}__annotator(protect,{'module':'FB','line':77,'column':0,'endLine':168,'endColumn':1,'name':'protect'},{params:['function','string','string','object'],returns:'?function'});
















function provide(name,source){return __bodyWrapper(this,arguments,function(){
var externalTarget=name?
dotAccess(externalInterface,name,true):
externalInterface;

ES(ES('Object','keys',false,source),'forEach',true,__annotator(function(key){return __bodyWrapper(this,arguments,function(){
var value=source[key];


if(typeof value === 'function'){
var accessor=(name?name + '.':'') + key;
var exportedProperty=protect(value,accessor,key,source);
if(exportedProperty){
externalTarget[key] = exportedProperty;}}else

if(typeof value === 'object'){

accessor = (name?name + '.':'') + key;
if(apiWhitelist && apiWhitelist[accessor]){
externalTarget[key] = value;}}},{params:[[key,'string','key']]});},{'module':'FB','line':188,'column':30,'endLine':205,'endColumn':3},{params:['string']}));},{params:[[name,'string','name'],[source,'object','source']]});}__annotator(provide,{'module':'FB','line':183,'column':0,'endLine':206,'endColumn':1,'name':'provide'},{params:['string','object']});







Runtime.setSecure(__annotator(function(){return __bodyWrapper(this,arguments,function(){

var inCanvas=/iframe_canvas|app_runner/.test(window.name);
var inDialog=/dialog/.test(window.name);



if(location.protocol == 'https:' && (
window == top || !(inCanvas || inDialog))){



return true;}




if(/_fb_https?/.test(window.name)){
return ES(window.name,'indexOf',true,'_fb_https') != -1;}},{returns:'?boolean'});},{'module':'FB','line':210,'column':19,'endLine':230,'endColumn':1},{returns:'?boolean'})());




ES('Object','assign',false,FB,{












provide:provide});



module.exports = FB;},{'module':'FB','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_FB'}),null);

__d('ArgumentError',['ManagedError'],__annotator(function $module_ArgumentError(global,require,requireDynamic,requireLazy,module,exports,ManagedError){if(require.__markCompiled)require.__markCompiled();



function ArgumentError(message,innerError){
ManagedError.prototype.constructor.apply(this,arguments);}__annotator(ArgumentError,{'module':'ArgumentError','line':12,'column':0,'endLine':14,'endColumn':1,'name':'ArgumentError'});

ArgumentError.prototype = new ManagedError();
ArgumentError.prototype.constructor = ArgumentError;

module.exports = ArgumentError;},{'module':'ArgumentError','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ArgumentError'}),null);

__d('CORSRequest',['wrapFunction','QueryString'],__annotator(function $module_CORSRequest(global,require,requireDynamic,requireLazy,module,exports,wrapFunction,QueryString){if(require.__markCompiled)require.__markCompiled();




function createCORSRequest(method,url){return __bodyWrapper(this,arguments,function(){
if(!self.XMLHttpRequest){
return null;}

var xhr=new XMLHttpRequest();
var noop=__annotator(function(){},{'module':'CORSRequest','line':30,'column':14,'endLine':30,'endColumn':27});
if('withCredentials' in xhr){
xhr.open(method,url,true);
xhr.setRequestHeader(
'Content-type','application/x-www-form-urlencoded');}else
if(self.XDomainRequest){
xhr = new XDomainRequest();
try{




xhr.open(method,url);







xhr.onprogress = xhr.ontimeout = noop;}
catch(accessDeniedError) {
return null;}}else

{
return null;}


var wrapper={
send:__annotator(function(data){return __bodyWrapper(this,arguments,function(){
xhr.send(data);},{params:[[data,'string','data']]});},{'module':'CORSRequest','line':59,'column':11,'endLine':61,'endColumn':6},{params:['string']})};


var onload=wrapFunction(__annotator(function(){
onload = noop;
if('onload' in wrapper){
wrapper.onload(xhr);}},{'module':'CORSRequest','line':63,'column':29,'endLine':68,'endColumn':4}),

'entry','XMLHttpRequest:load');
var onerror=wrapFunction(__annotator(function(){
onerror = noop;
if('onerror' in wrapper){
wrapper.onerror(xhr);}},{'module':'CORSRequest','line':69,'column':30,'endLine':74,'endColumn':4}),

'entry','XMLHttpRequest:error');






xhr.onload = __annotator(function(){
onload();},{'module':'CORSRequest','line':81,'column':16,'endLine':83,'endColumn':4});


xhr.onerror = __annotator(function(){
onerror();},{'module':'CORSRequest','line':85,'column':17,'endLine':87,'endColumn':4});


xhr.onreadystatechange = __annotator(function(){
if(xhr.readyState == 4){
if(xhr.status == 200){
onload();}else
{
onerror();}}},{'module':'CORSRequest','line':89,'column':28,'endLine':97,'endColumn':4});




return wrapper;},{params:[[method,'string','method'],[url,'string','url']],returns:'?object'});}__annotator(createCORSRequest,{'module':'CORSRequest','line':25,'column':0,'endLine':100,'endColumn':1,'name':'createCORSRequest'},{params:['string','string'],returns:'?object'});


function execute(url,method,params,
cb){return __bodyWrapper(this,arguments,function(){
params.suppress_http_code = 1;
var data=QueryString.encode(params);

if(method != 'post'){
url = QueryString.appendToUrl(url,data);
data = '';}


var request=createCORSRequest(method,url);
if(!request){
return false;}


request.onload = __annotator(function(xhr){
cb(ES('JSON','parse',false,xhr.responseText));},{'module':'CORSRequest','line':117,'column':19,'endLine':119,'endColumn':3});

request.onerror = __annotator(function(xhr){
if(xhr.responseText){
cb(ES('JSON','parse',false,xhr.responseText));}else
{
cb({
error:{
type:'http',
message:'unknown error',
status:xhr.status}});}},{'module':'CORSRequest','line':120,'column':20,'endLine':132,'endColumn':3});




request.send(data);
return true;},{params:[[url,'string','url'],[method,'string','method'],[params,'object','params'],[cb,'function','cb']],returns:'boolean'});}__annotator(execute,{'module':'CORSRequest','line':102,'column':0,'endLine':135,'endColumn':1,'name':'execute'},{params:['string','string','object','function'],returns:'boolean'});


var CORSRequest={
execute:execute};

module.exports = CORSRequest;},{'module':'CORSRequest','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_CORSRequest'}),null);

__d('FlashRequest',['DOMWrapper','Flash','GlobalCallback','QueryString','Queue'],__annotator(function $module_FlashRequest(global,require,requireDynamic,requireLazy,module,exports,DOMWrapper,Flash,GlobalCallback,QueryString,Queue){if(require.__markCompiled)require.__markCompiled();







var flashQueue;
var requestCallbacks={};
var swfUrl;
var swf;

function initFlash(){
if(!swfUrl){
throw new Error('swfUrl has not been set');}


var initCallback=GlobalCallback.create(__annotator(function(){
flashQueue.start(__annotator(function(item){return __bodyWrapper(this,arguments,function(){
var id=swf.execute(
item.method,
item.url,
item.body);

if(!id){
throw new Error('Could create request');}

requestCallbacks[id] = item.callback;},{params:[[item,'object','item']]});},{'module':'FlashRequest','line':42,'column':21,'endLine':52,'endColumn':5},{params:['object']}));},{'module':'FlashRequest','line':41,'column':43,'endLine':53,'endColumn':3}));




var requestCallback=GlobalCallback.create(__annotator(function(id,
status,response){return __bodyWrapper(this,arguments,function(){
var data;
try{
data = ES('JSON','parse',false,decodeURIComponent(response));}
catch(parseError) {
data = {
error:{
type:'SyntaxError',
message:parseError.message,
status:status,
raw:response}};}




requestCallbacks[id](data);
delete requestCallbacks[id];},{params:[[id,'number','id'],[status,'number','status'],[response,'string','response']]});},{'module':'FlashRequest','line':56,'column':46,'endLine':74,'endColumn':3},{params:['number','number','string']}));


swf = Flash.embed(swfUrl,DOMWrapper.getRoot(),null,{
log:__DEV__?true:false,
initCallback:initCallback,
requestCallback:requestCallback});}__annotator(initFlash,{'module':'FlashRequest','line':36,'column':0,'endLine':81,'endColumn':1,'name':'initFlash'});











function execute(url,method,params,
cb){return __bodyWrapper(this,arguments,function(){


params.suppress_http_code = 1;




if(!params.method){
params.method = method;}



var body=QueryString.encode(params);
if(method === 'get' && url.length + body.length < 2000){


url = QueryString.appendToUrl(url,body);
body = '';}else
{
method = 'post';}



if(!flashQueue){
if(!Flash.isAvailable()){
return false;}

flashQueue = new Queue();
initFlash();}



flashQueue.enqueue({
method:method,
url:url,
body:body,
callback:cb});

return true;},{params:[[url,'string','url'],[method,'string','method'],[params,'object','params'],[cb,'function','cb']],returns:'boolean'});}__annotator(execute,{'module':'FlashRequest','line':91,'column':0,'endLine':132,'endColumn':1,'name':'execute'},{params:['string','string','object','function'],returns:'boolean'});


var FlashRequest={
setSwfUrl:__annotator(function(swf_url){return __bodyWrapper(this,arguments,function(){
swfUrl = swf_url;},{params:[[swf_url,'string','swf_url']]});},{'module':'FlashRequest','line':135,'column':13,'endLine':137,'endColumn':3},{params:['string']}),

execute:execute};


module.exports = FlashRequest;},{'module':'FlashRequest','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_FlashRequest'}),null);

__d('JSONPRequest',['DOMWrapper','GlobalCallback','QueryString'],__annotator(function $module_JSONPRequest(global,require,requireDynamic,requireLazy,module,exports,DOMWrapper,GlobalCallback,QueryString){if(require.__markCompiled)require.__markCompiled();





var MAX_QUERYSTRING_LENGTH=2000;









function execute(url,method,params,
cb){return __bodyWrapper(this,arguments,function(){
var script=document.createElement('script');

var callbackWrapper=__annotator(function(response){
callbackWrapper = __annotator(function(){},{'module':'JSONPRequest','line':41,'column':22,'endLine':41,'endColumn':35});
GlobalCallback.remove(params.callback);
cb(response);
script.parentNode.removeChild(script);},{'module':'JSONPRequest','line':40,'column':24,'endLine':45,'endColumn':3});


params.callback = GlobalCallback.create(callbackWrapper);


if(!params.method){
params.method = method;}


url = QueryString.appendToUrl(url,params);
if(url.length > MAX_QUERYSTRING_LENGTH){
GlobalCallback.remove(params.callback);
return false;}



script.onerror = __annotator(function(){
callbackWrapper({
error:{
type:'http',
message:'unknown error'}});},{'module':'JSONPRequest','line':61,'column':19,'endLine':68,'endColumn':3});





var ensureCallbackCalled=__annotator(function(){
setTimeout(__annotator(function(){


callbackWrapper({
error:{
type:'http',
message:'unknown error'}});},{'module':'JSONPRequest','line':72,'column':15,'endLine':81,'endColumn':5}),


0);},{'module':'JSONPRequest','line':71,'column':29,'endLine':82,'endColumn':3});

if(script.addEventListener){
script.addEventListener('load',ensureCallbackCalled,false);}else
{
script.onreadystatechange = __annotator(function(){
if(/loaded|complete/.test(this.readyState)){
ensureCallbackCalled();}},{'module':'JSONPRequest','line':86,'column':32,'endLine':90,'endColumn':5});}




script.src = url;
DOMWrapper.getRoot().appendChild(script);
return true;},{params:[[url,'string','url'],[method,'string','method'],[params,'object','params'],[cb,'function','cb']],returns:'boolean'});}__annotator(execute,{'module':'JSONPRequest','line':36,'column':0,'endLine':96,'endColumn':1,'name':'execute'},{params:['string','string','object','function'],returns:'boolean'});


var JSONPRequest={
execute:execute,
MAX_QUERYSTRING_LENGTH:MAX_QUERYSTRING_LENGTH};


module.exports = JSONPRequest;},{'module':'JSONPRequest','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_JSONPRequest'}),null);

__d('flattenObject',[],__annotator(function $module_flattenObject(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();










function flattenObject(obj){return __bodyWrapper(this,arguments,function(){
var flat={};
for(var key in obj) {
if(obj.hasOwnProperty(key)){
var value=obj[key];
if(null === value || undefined === value){
continue;}else
if(typeof value == 'string'){
flat[key] = value;}else
{
flat[key] = ES('JSON','stringify',false,value);}}}


return flat;},{params:[[obj,'object','obj']],returns:'object'});}__annotator(flattenObject,{'module':'flattenObject','line':17,'column':0,'endLine':31,'endColumn':1,'name':'flattenObject'},{params:['object'],returns:'object'});


module.exports = flattenObject;},{'module':'flattenObject','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_flattenObject'}),null);

__d('ApiClient',['ArgumentError','Assert','CORSRequest','FlashRequest','flattenObject','JSONPRequest','Log','ObservableMixin','QueryString','sprintf','sdk.URI','UrlMap','ApiClientConfig','invariant'],__annotator(function $module_ApiClient(global,require,requireDynamic,requireLazy,module,exports,ArgumentError,Assert,CORSRequest,FlashRequest,flattenObject,JSONPRequest,Log,ObservableMixin,QueryString,sprintf,URI,UrlMap,ApiClientConfig,invariant){if(require.__markCompiled)require.__markCompiled();


















var accessToken;
var clientID;
var defaultParams;

var MAX_QUERYSTRING_LENGTH=JSONPRequest.MAX_QUERYSTRING_LENGTH;
var METHODS={
'get':true,
'post':true,
'delete':true,
'put':true};


var READONLYCALLS={
fql_query:true,
fql_multiquery:true,
friends_get:true,
notifications_get:true,
stream_get:true,
users_getinfo:true};


var defaultTransports=['jsonp','cors','flash'];


var batchCalls=[];
var batchCallbacks=[];
var scheduleId=null;

var currentlyExecutingRequests=0;
var requestQueue=[];
var maxConcurrentRequests=0;



var REQUESTS_PER_BATCH=50;




var DEFAULT_BATCH_APP_ID=105440539523;









function request(url,method,params,
cb){return __bodyWrapper(this,arguments,function(){


var shouldQueueRequest=
maxConcurrentRequests !== 0 &&
currentlyExecutingRequests >= maxConcurrentRequests;

if(shouldQueueRequest){


requestQueue.push(__annotator(function(){return request(url,method,params,cb);},{'module':'ApiClient','line':86,'column':22,'endLine':86,'endColumn':60}));
ApiClient.inform(
'request.queued',
url,
method,
params);

return;}


currentlyExecutingRequests++;

if(defaultParams){
params = ES('Object','assign',false,{},defaultParams,params);}


params.access_token = params.access_token || accessToken;
params.pretty = params.pretty || 0;

params = flattenObject(params);
var availableTransports={
jsonp:JSONPRequest,
cors:CORSRequest,
flash:FlashRequest};




var transports;
if(params.transport){
transports = [params.transport];
delete params.transport;}else
{
transports = defaultTransports;}


for(var i=0;i < transports.length;i++) {
var transport=availableTransports[transports[i]];
var paramsCopy=ES('Object','assign',false,{},params);
if(transport.execute(url,method,paramsCopy,cb)){
return;}}



cb({
error:{
type:'no-transport',
message:'Could not find a usable transport for request'}});},{params:[[url,'string','url'],[method,'string','method'],[params,'object','params'],[cb,'function','cb']]});}__annotator(request,{'module':'ApiClient','line':75,'column':0,'endLine':136,'endColumn':1,'name':'request'},{params:['string','string','object','function']});




function inspect(callback,endpoint,method,
params,startTime,response){return __bodyWrapper(this,arguments,function(){
if(response && response.error){
ApiClient.inform(
'request.error',
endpoint,
method,
params,
response,
ES('Date','now',false) - startTime);}



ApiClient.inform(
'request.complete',
endpoint,
method,
params,
response,
ES('Date','now',false) - startTime);



currentlyExecutingRequests--;
if(callback){
callback(response);}




var shouldExecuteQueuedRequest=
requestQueue.length > 0 &&
currentlyExecutingRequests < maxConcurrentRequests;
if(shouldExecuteQueuedRequest){
var nextRequest=requestQueue.shift();
nextRequest();}},{params:[[callback,'?function','callback'],[endpoint,'string','endpoint'],[method,'string','method'],[params,'object','params'],[startTime,'number','startTime']]});}__annotator(inspect,{'module':'ApiClient','line':138,'column':0,'endLine':175,'endColumn':1,'name':'inspect'},{params:['?function','string','string','object','number']});







function parseCallDataFromArgs(args){return __bodyWrapper(this,arguments,function(){
var path=args.shift();
Assert.isString(path,'Invalid path');
if(!/^https?/.test(path) && path.charAt(0) !== '/'){
path = '/' + path;}


var uri;
var argsMap={};

try{
uri = new URI(path);}
catch(e) {
throw new ArgumentError(e.message,e);}



ES(args,'forEach',true,__annotator(function(arg){return argsMap[typeof arg] = arg;},{'module':'ApiClient','line':198,'column':15,'endLine':198,'endColumn':47}));

var method=(argsMap.string || 'get').toLowerCase();

Assert.isTrue(
METHODS.hasOwnProperty(method),
sprintf('Invalid method passed to ApiClient: %s',method));


var callback=argsMap['function'];
if(!callback){
Log.warn('No callback passed to the ApiClient');}


if(argsMap.object){
uri.addQueryData(flattenObject(argsMap.object));}


var params=uri.getQueryData();
params.method = method;

return {uri:uri,callback:callback,params:params};},{params:[[args,'array','args']]});}__annotator(parseCallDataFromArgs,{'module':'ApiClient','line':181,'column':0,'endLine':220,'endColumn':1,'name':'parseCallDataFromArgs'},{params:['array']});

























function requestUsingGraph(){for(var _len=arguments.length,args=Array(_len),_key=0;_key < _len;_key++) {args[_key] = arguments[_key];}var _parseCallDataFromArgs=
parseCallDataFromArgs(args);var uri=_parseCallDataFromArgs.uri;var callback=_parseCallDataFromArgs.callback;var params=_parseCallDataFromArgs.params;
var method=params.method;

if(requestIsTooLargeForGet(uri,method)){
method = 'post';}


var url=uri.getProtocol() && uri.getDomain()?
uri.setQueryData({}).toString():
UrlMap.resolve('graph') + uri.getPath();

ApiClient.inform('request.prepare',url,params);

request(
url,
method == 'get'?'get':'post',
params,ES(
inspect,'bind',true,null,callback,uri.getPath(),method,params,ES('Date','now',false)));}__annotator(requestUsingGraph,{'module':'ApiClient','line':245,'column':0,'endLine':265,'endColumn':1,'name':'requestUsingGraph'});



function prepareBatchParams(args){return __bodyWrapper(this,arguments,function(){var _parseCallDataFromArgs2=
parseCallDataFromArgs(args);var uri=_parseCallDataFromArgs2.uri;var callback=_parseCallDataFromArgs2.callback;var method=_parseCallDataFromArgs2.params.method;

var body;
var relative_url=uri.removeQueryData('method').toString();
if(method.toLowerCase() == 'post'){
body = QueryString.encode(uri.getQueryData());
relative_url = uri.setQueryData({}).toString();}


return {
body:body,
callback:callback,
method:method,
relative_url:relative_url};},{params:[[args,'array','args']]});}__annotator(prepareBatchParams,{'module':'ApiClient','line':267,'column':0,'endLine':283,'endColumn':1,'name':'prepareBatchParams'},{params:['array']});






function scheduleBatchCall(){for(var _len2=arguments.length,args=Array(_len2),_key2=0;_key2 < _len2;_key2++) {args[_key2] = arguments[_key2];}var _prepareBatchParams=
prepareBatchParams(args);var body=_prepareBatchParams.body;var callback=_prepareBatchParams.callback;var method=_prepareBatchParams.method;var relative_url=_prepareBatchParams.relative_url;

var batchCall={
method:method,
relative_url:relative_url};


if(body){
batchCall.body = body;}


batchCalls.push(batchCall);
batchCallbacks.push(callback);



if(batchCalls.length == REQUESTS_PER_BATCH){
if(scheduleId){
clearTimeout(scheduleId);}

dispatchBatchCalls();}else
if(!scheduleId){

scheduleId = setTimeout(dispatchBatchCalls,0);}}__annotator(scheduleBatchCall,{'module':'ApiClient','line':288,'column':0,'endLine':314,'endColumn':1,'name':'scheduleBatchCall'});







function dispatchBatchCalls(){
!(
batchCalls.length > 0)?invariant(0,
'ApiClient: batchCalls is empty at dispatch.'):undefined;

!(
batchCalls.length === batchCallbacks.length)?invariant(0,
'ApiClient: Every batch call should have a callback'):undefined;




var copiedBatchCalls=batchCalls;
var copiedBatchCallbacks=batchCallbacks;

batchCalls = [];
batchCallbacks = [];
scheduleId = null;


if(copiedBatchCalls.length === 1){
var call=copiedBatchCalls[0];
var callback=copiedBatchCallbacks[0];


var body=call.body?QueryString.decode(call.body):null;

requestUsingGraph(
call.relative_url,
call.method,
body,
callback);

return;}


requestUsingGraph(
'/',
'POST',
{
batch:copiedBatchCalls,
include_headers:false,
batch_app_id:clientID || DEFAULT_BATCH_APP_ID},__annotator(

function(response){
if(ES('Array','isArray',false,response)){
ES(response,'forEach',true,__annotator(function(data,idx){
copiedBatchCallbacks[idx](ES('JSON','parse',false,data.body));},{'module':'ApiClient','line':366,'column':25,'endLine':368,'endColumn':9}));}else

{
ES(copiedBatchCallbacks,'forEach',true,__annotator(function(callback){return (
callback({error:{message:'Fatal: batch call failed.'}}));},{'module':'ApiClient','line':370,'column':37,'endLine':371,'endColumn':67}));}},{'module':'ApiClient','line':364,'column':4,'endLine':374,'endColumn':5}));}__annotator(dispatchBatchCalls,{'module':'ApiClient','line':320,'column':0,'endLine':376,'endColumn':1,'name':'dispatchBatchCalls'});

















function requestUsingRest(params,cb){return __bodyWrapper(this,arguments,function(){
Assert.isObject(params);
Assert.isString(params.method,'method missing');

if(!cb){
Log.warn('No callback passed to the ApiClient');}

var method=params.method.toLowerCase().replace('.','_');
params.format = 'json-strings';
params.api_key = clientID;

var domain=method in READONLYCALLS?'api_read':'api';
var url=UrlMap.resolve(domain) + '/restserver.php';
var inspector=ES(
inspect,'bind',true,null,cb,'/restserver.php','get',params,ES('Date','now',false));
request(url,'get',params,inspector);},{params:[[params,'object','params'],[cb,'?function','cb']]});}__annotator(requestUsingRest,{'module':'ApiClient','line':389,'column':0,'endLine':405,'endColumn':1,'name':'requestUsingRest'},{params:['object','?function']});


var ApiClient=ES('Object','assign',false,new ObservableMixin(),{
setAccessToken:__annotator(function(access_token){return __bodyWrapper(this,arguments,function(){
if(__DEV__){
if(accessToken && accessToken !== access_token){
console.error(
'You are overriding current access token, that means some other ' +
'app is expecting different access token and you will probably ' +
'break things. Please consider passing access_token directly to ' +
'API parameters instead of overriding the global settings.');}}



accessToken = access_token;},{params:[[access_token,'?string','access_token']]});},{'module':'ApiClient','line':408,'column':16,'endLine':420,'endColumn':3},{params:['?string']}),

setAccessTokenForClientID:__annotator(function(access_token,client_id){return __bodyWrapper(this,arguments,function(){
if(accessToken && clientID && clientID !== client_id){
console.error(
'Not overriding access token since it was not ' +
'initialized by your application.');}else

{
accessToken = access_token;}},{params:[[access_token,'?string','access_token'],[client_id,'string','client_id']]});},{'module':'ApiClient','line':421,'column':27,'endLine':430,'endColumn':3},{params:['?string','string']}),


getAccessToken:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return accessToken;},{returns:'string'});},{'module':'ApiClient','line':431,'column':16,'endLine':433,'endColumn':3},{returns:'string'}),

setClientID:__annotator(function(client_id){return __bodyWrapper(this,arguments,function(){
clientID = client_id;},{params:[[client_id,'?string','client_id']]});},{'module':'ApiClient','line':434,'column':13,'endLine':436,'endColumn':3},{params:['?string']}),

setDefaultParams:__annotator(function(default_params){return __bodyWrapper(this,arguments,function(){
defaultParams = default_params;},{params:[[default_params,'?object','default_params']]});},{'module':'ApiClient','line':437,'column':18,'endLine':439,'endColumn':3},{params:['?object']}),

setDefaultTransports:__annotator(function(newDefaultTransports){return __bodyWrapper(this,arguments,function(){
defaultTransports = newDefaultTransports;},{params:[[newDefaultTransports,'array<string>','newDefaultTransports']]});},{'module':'ApiClient','line':440,'column':22,'endLine':442,'endColumn':3},{params:['array<string>']}),

setMaxConcurrentRequests:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
maxConcurrentRequests = value;},{params:[[value,'number','value']]});},{'module':'ApiClient','line':443,'column':26,'endLine':445,'endColumn':3},{params:['number']}),

getCurrentlyExecutingRequestCount:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return currentlyExecutingRequests;},{returns:'number'});},{'module':'ApiClient','line':446,'column':35,'endLine':448,'endColumn':3},{returns:'number'}),

getQueuedRequestCount:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return requestQueue.length;},{returns:'number'});},{'module':'ApiClient','line':449,'column':23,'endLine':451,'endColumn':3},{returns:'number'}),

rest:requestUsingRest,
graph:requestUsingGraph,
scheduleBatchCall:scheduleBatchCall,
prepareBatchParams:prepareBatchParams});


function requestIsTooLargeForGet(uri,method){return __bodyWrapper(this,arguments,function(){
return uri.toString().length > MAX_QUERYSTRING_LENGTH && method === 'get';},{params:[[uri,'URI','uri'],[method,'?string','method']],returns:'boolean'});}__annotator(requestIsTooLargeForGet,{'module':'ApiClient','line':458,'column':0,'endLine':460,'endColumn':1,'name':'requestIsTooLargeForGet'},{params:['URI','?string'],returns:'boolean'});



FlashRequest.setSwfUrl(ApiClientConfig.FlashRequest.swfUrl);

module.exports = ApiClient;},{'module':'ApiClient','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_ApiClient'}),null);

__d('sdk.PlatformVersioning',['sdk.Runtime','ManagedError'],__annotator(function $module_sdk_PlatformVersioning(global,require,requireDynamic,requireLazy,module,exports,Runtime,ManagedError){if(require.__markCompiled)require.__markCompiled();




var REGEX=/^v\d+\.\d\d?$/;

var PlatformVersioning={

REGEX:REGEX,

assertVersionIsSet:__annotator(function(){
if(!Runtime.getVersion()){
throw new ManagedError('init not called with valid version');}},{'module':'sdk.PlatformVersioning','line':17,'column':22,'endLine':21,'endColumn':3}),



assertValidVersion:__annotator(function(version){return __bodyWrapper(this,arguments,function(){
if(!REGEX.test(version)){
throw new ManagedError('invalid version specified');}},{params:[[version,'string','version']]});},{'module':'sdk.PlatformVersioning','line':23,'column':22,'endLine':27,'endColumn':3},{params:['string']})};





module.exports = PlatformVersioning;},{'module':'sdk.PlatformVersioning','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_PlatformVersioning'}),null);

__d('sdk.api',['ApiClient','sdk.PlatformVersioning','sdk.Runtime','sdk.Scribe','sdk.URI','sdk.feature'],__annotator(function $module_sdk_api(global,require,requireDynamic,requireLazy,module,exports,ApiClient,PlatformVersioning,Runtime,Scribe,URI,feature){if(require.__markCompiled)require.__markCompiled();








var shouldLogResponseError=feature('should_log_response_error',false);

var currentAccessToken;

Runtime.subscribe(
'ClientID.change',__annotator(
function(value){return __bodyWrapper(this,arguments,function(){return ApiClient.setClientID(value);},{params:[[value,'?string','value']]});},{'module':'sdk.api','line':21,'column':2,'endLine':21,'endColumn':53},{params:['?string']}));


Runtime.subscribe(
'AccessToken.change',__annotator(
function(value){return __bodyWrapper(this,arguments,function(){
currentAccessToken = value;
ApiClient.setAccessToken(value);},{params:[[value,'?string','value']]});},{'module':'sdk.api','line':26,'column':2,'endLine':29,'endColumn':3},{params:['?string']}));



ApiClient.setDefaultParams({
sdk:'joey'});



ApiClient.subscribe(
'request.complete',__annotator(
function(endpoint,method,params,response){return __bodyWrapper(this,arguments,function(){
var invalidateToken=false;
if(response && typeof response == 'object'){
if(response.error){
if(response.error == 'invalid_token' ||
response.error.type == 'OAuthException' &&
response.error.code == 190){
invalidateToken = true;}}else

if(response.error_code){
if(response.error_code == '190'){
invalidateToken = true;}}}



if(invalidateToken &&
currentAccessToken === Runtime.getAccessToken()){

Runtime.setAccessToken(null);}},{params:[[endpoint,'string','endpoint'],[method,'string','method'],[params,'object','params']]});},{'module':'sdk.api','line':39,'column':2,'endLine':59,'endColumn':1},{params:['string','string','object']}));




ApiClient.subscribe(
'request.complete',__annotator(
function(endpoint,method,params,response){return __bodyWrapper(this,arguments,function(){
if((endpoint == '/me/permissions' &&
method === 'delete' ||
endpoint == '/restserver.php' &&
params.method == 'Auth.revokeAuthorization') &&
response === true){
Runtime.setAccessToken(null);}},{params:[[endpoint,'string','endpoint'],[method,'string','method'],[params,'object','params']]});},{'module':'sdk.api','line':64,'column':2,'endLine':72,'endColumn':3},{params:['string','string','object']}));





ApiClient.subscribe(
'request.error',__annotator(
function(endpoint,method,params,response){return __bodyWrapper(this,arguments,function(){
if(shouldLogResponseError && response.error.type === 'http'){
Scribe.log('jssdk_error',{
appId:Runtime.getClientID(),
error:'transport',
extra:{
name:'transport',

message:ES('JSON','stringify',false,response.error)}});}},{params:[[endpoint,'string','endpoint'],[method,'string','method'],[params,'object','params']]});},{'module':'sdk.api','line':78,'column':2,'endLine':90,'endColumn':3},{params:['string','string','object']}));












function api(path){


if(typeof path === 'string'){
if(Runtime.getIsVersioned()){
PlatformVersioning.assertVersionIsSet();


if(!/https?/.test(path) && path.charAt(0) !== '/'){
path = '/' + path;}

path = new URI(path).setDomain(null).setProtocol(null).toString();


if(!PlatformVersioning.REGEX.
test(path.substring(1,ES(path,'indexOf',true,'/',1)))){
path = '/' + Runtime.getVersion() + path;}


var args=[path].concat(Array.prototype.slice.call(arguments,1));
ApiClient.graph.apply(ApiClient,args);}else
{
ApiClient.graph.apply(ApiClient,arguments);}}else

{
ApiClient.rest.apply(ApiClient,arguments);}}__annotator(api,{'module':'sdk.api','line':99,'column':0,'endLine':126,'endColumn':1,'name':'api'});



module.exports = api;},{'module':'sdk.api','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_api'}),null);

__d('legacy:fb.api',['FB','sdk.api'],__annotator(function $module_legacy_fb_api(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,FB,api){if(require.__markCompiled)require.__markCompiled();




FB.provide('',{
api:api});},{'module':'legacy:fb.api','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_api'}),3);

__d('sdk.AppEvents',['Assert','sdk.Impressions','sdk.Runtime'],__annotator(function $module_sdk_AppEvents(global,require,requireDynamic,requireLazy,module,exports,Assert,Impressions,Runtime){if(require.__markCompiled)require.__markCompiled();





var EventNames={
COMPLETED_REGISTRATION:'fb_mobile_complete_registration',
VIEWED_CONTENT:'fb_mobile_content_view',
SEARCHED:'fb_mobile_search',
RATED:'fb_mobile_rate',
COMPLETED_TUTORIAL:'fb_mobile_tutorial_completion',
ADDED_TO_CART:'fb_mobile_add_to_cart',
ADDED_TO_WISHLIST:'fb_mobile_add_to_wishlist',
INITIATED_CHECKOUT:'fb_mobile_initiated_checkout',
ADDED_PAYMENT_INFO:'fb_mobile_add_payment_info',
ACHIEVED_LEVEL:'fb_mobile_level_achieved',
UNLOCKED_ACHIEVEMENT:'fb_mobile_achievement_unlocked',
SPENT_CREDITS:'fb_mobile_spent_credits'};




var HiddenEventNames={
ACTIVATED_APP:'fb_mobile_activate_app',
PURCHASED:'fb_mobile_purchase'};


var ParameterNames={
CURRENCY:'fb_currency',
REGISTRATION_METHOD:'fb_registration_method',
CONTENT_TYPE:'fb_content_type',
CONTENT_ID:'fb_content_id',
SEARCH_STRING:'fb_search_string',
SUCCESS:'fb_success',
MAX_RATING_VALUE:'fb_max_rating_value',
PAYMENT_INFO_AVAILABLE:'fb_payment_info_available',
NUM_ITEMS:'fb_num_items',
LEVEL:'fb_level',
DESCRIPTION:'fb_description'};


var MAX_EVENT_NAME_LENGTH=40;
var EVENT_NAME_REGEX='^[0-9a-zA-Z_]+[0-9a-zA-Z _-]*$';

function logEvent(
appID,
eventName,
valueToSum,
params){return __bodyWrapper(this,arguments,function()
{
Assert.isTrue(
isValidEventName(eventName),
'Invalid event name: ' + eventName + '. ' +
'It must be between 1 and ' + MAX_EVENT_NAME_LENGTH + ' characters, ' +
'and must be contain only alphanumerics, _, - or spaces, ' +
'starting with alphanumeric or _.');

var payload={
ae:1,
ev:eventName,
vts:valueToSum,
canvas:Runtime.isCanvasEnvironment()?1:0};

if(params){
payload.cd = params;}

Impressions.impression(
{
api_key:appID,
payload:ES('JSON','stringify',false,payload)});},{params:[[appID,'string','appID'],[eventName,'string','eventName'],[valueToSum,'?number','valueToSum'],[params,'?object','params']]});}__annotator(logEvent,{'module':'sdk.AppEvents','line':51,'column':0,'endLine':79,'endColumn':1,'name':'logEvent'},{params:['string','string','?number','?object']});




function isValidEventName(eventName){return __bodyWrapper(this,arguments,function(){
if(eventName === null ||
eventName.length === 0 ||
eventName.length > MAX_EVENT_NAME_LENGTH ||
!new RegExp(EVENT_NAME_REGEX).test(eventName))
{
return false;}


return true;},{params:[[eventName,'string','eventName']],returns:'boolean'});}__annotator(isValidEventName,{'module':'sdk.AppEvents','line':81,'column':0,'endLine':91,'endColumn':1,'name':'isValidEventName'},{params:['string'],returns:'boolean'});


function logPurchase(
appID,
purchaseAmount,
currency,
params){return __bodyWrapper(this,arguments,function()
{
var extraParams={};
extraParams[ParameterNames.CURRENCY] = currency;
logEvent(
appID,
HiddenEventNames.PURCHASED,
purchaseAmount,babelHelpers._extends({},

params,
extraParams));},{params:[[appID,'string','appID'],[purchaseAmount,'number','purchaseAmount'],[currency,'string','currency'],[params,'?object','params']]});}__annotator(logPurchase,{'module':'sdk.AppEvents','line':93,'column':0,'endLine':110,'endColumn':1,'name':'logPurchase'},{params:['string','number','string','?object']});




function activateApp(appID){return __bodyWrapper(this,arguments,function(){
logEvent(appID,HiddenEventNames.ACTIVATED_APP);},{params:[[appID,'string','appID']]});}__annotator(activateApp,{'module':'sdk.AppEvents','line':112,'column':0,'endLine':114,'endColumn':1,'name':'activateApp'},{params:['string']});


module.exports = {
activateApp:activateApp,
logEvent:logEvent,
logPurchase:logPurchase,
isValidEventName:isValidEventName,
EventNames:EventNames,
ParameterNames:ParameterNames};},{'module':'sdk.AppEvents','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_AppEvents'}),null);

__d('legacy:fb.appevents',['Assert','sdk.AppEvents','FB','sdk.feature','sdk.Runtime'],__annotator(function $module_legacy_fb_appevents(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,Assert,AppEvents,FB,feature,Runtime){if(require.__markCompiled)require.__markCompiled();







FB.provide('AppEvents',{
logEvent:__annotator(function(
eventName,
valueToSum,
params){return __bodyWrapper(this,arguments,function()
{
Assert.isTrue(
feature('allow_non_canvas_app_events',false) ||
Runtime.isCanvasEnvironment(),
'You can only use this function in Facebook Canvas environment');

Assert.isString(eventName,'Invalid eventName');
Assert.maybeNumber(valueToSum,'Invalid valueToSum');
Assert.maybeObject(params,'Invalid params');
var appID=Runtime.getClientID();
Assert.isTrue(
appID !== null && appID.length > 0,
'You need to call FB.init() with App ID first.');

AppEvents.logEvent(appID,eventName,valueToSum,params);},{params:[[eventName,'string','eventName'],[valueToSum,'?number','valueToSum'],[params,'?object','params']]});},{'module':'legacy:fb.appevents','line':15,'column':10,'endLine':34,'endColumn':3},{params:['string','?number','?object']}),


logPurchase:__annotator(function(
purchaseAmount,
currency,
params){return __bodyWrapper(this,arguments,function()
{
Assert.isTrue(
feature('allow_non_canvas_app_events',false) ||
Runtime.isCanvasEnvironment(),
'You can only use this function in Facebook Canvas environment');

Assert.isNumber(purchaseAmount,'Invalid purchaseAmount');
Assert.isString(currency,'Invalid currency');
Assert.maybeObject(params,'Invalid params');
var appID=Runtime.getClientID();
Assert.isTrue(
appID !== null && appID.length > 0,
'You need to call FB.init() with App ID first.');

AppEvents.logPurchase(appID,purchaseAmount,currency,params);},{params:[[purchaseAmount,'number','purchaseAmount'],[currency,'string','currency'],[params,'?object','params']]});},{'module':'legacy:fb.appevents','line':36,'column':13,'endLine':55,'endColumn':3},{params:['number','string','?object']}),


activateApp:__annotator(function(){
Assert.isTrue(
feature('allow_non_canvas_app_events',false) ||
Runtime.isCanvasEnvironment(),
'You can only use this function in Facebook Canvas environment');

var appID=Runtime.getClientID();
Assert.isTrue(
appID !== null && appID.length > 0,
'You need to call FB.init() with App ID first.');

AppEvents.activateApp(appID);},{'module':'legacy:fb.appevents','line':57,'column':13,'endLine':69,'endColumn':3}),


EventNames:AppEvents.EventNames,

ParameterNames:AppEvents.ParameterNames});},{'module':'legacy:fb.appevents','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_appevents'}),3);

__d('resolveURI',[],__annotator(function $module_resolveURI(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function resolveURI(uri){return __bodyWrapper(this,arguments,function(){
if(!uri){
return window.location.href;}


uri = uri.replace(/&/g,'&amp;').
replace(/"/g,'&quot;');

var div=document.createElement('div');


div.innerHTML = '<a href="' + uri + '"></a>';

return div.firstChild.href;},{params:[[uri,'?string','uri']],returns:'string'});}__annotator(resolveURI,{'module':'resolveURI','line':11,'column':0,'endLine':25,'endColumn':1,'name':'resolveURI'},{params:['?string'],returns:'string'});


module.exports = resolveURI;},{'module':'resolveURI','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_resolveURI'}),null);

__d('sdk.Canvas.Environment',['sdk.RPC'],__annotator(function $module_sdk_Canvas_Environment(global,require,requireDynamic,requireLazy,module,exports,RPC){if(require.__markCompiled)require.__markCompiled();



function getPageInfo(appCallback){return __bodyWrapper(this,arguments,function(){
RPC.remote.getPageInfo(__annotator(function(response){return __bodyWrapper(this,arguments,function(){
appCallback(response.result);},{params:[[response,'object','response']]});},{'module':'sdk.Canvas.Environment','line':11,'column':25,'endLine':13,'endColumn':3},{params:['object']}));},{params:[[appCallback,'function','appCallback']]});}__annotator(getPageInfo,{'module':'sdk.Canvas.Environment','line':10,'column':0,'endLine':14,'endColumn':1,'name':'getPageInfo'},{params:['function']});



function scrollTo(x,y){return __bodyWrapper(this,arguments,function(){
RPC.remote.scrollTo({x:x || 0,y:y || 0});},{params:[[x,'?number','x'],[y,'?number','y']]});}__annotator(scrollTo,{'module':'sdk.Canvas.Environment','line':16,'column':0,'endLine':18,'endColumn':1,'name':'scrollTo'},{params:['?number','?number']});



RPC.stub('getPageInfo');
RPC.stub('scrollTo');

var Environment={
getPageInfo:getPageInfo,
scrollTo:scrollTo};


module.exports = Environment;},{'module':'sdk.Canvas.Environment','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Canvas_Environment'}),null);

__d('sdk.fbt',[],__annotator(function $module_sdk_fbt(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();




var fbt={
_:__annotator(function(table){
if(__DEV__){
if(arguments.length > 1){
throw 'You are not using a simple string';}}


return typeof table === 'string'?table:table[0];},{'module':'sdk.fbt','line':11,'column':3,'endLine':18,'endColumn':3})};


module.exports = fbt;},{'module':'sdk.fbt','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_fbt'}),null);

__d('sdk.Dialog',['sdk.Canvas.Environment','sdk.Content','sdk.DOM','DOMEventListener','ObservableMixin','sdk.Runtime','Type','sdk.UA','sdk.fbt','sdk.feature'],__annotator(function $module_sdk_Dialog(global,require,requireDynamic,requireLazy,module,exports,CanvasEnvironment,Content,DOM,DOMEventListener,ObservableMixin,Runtime,Type,UA,fbt,feature){if(require.__markCompiled)require.__markCompiled();












var MARGIN_SURROUNDING=30;

var MAX_HEIGHT_MOBILE=590;
var MAX_WIDTH_MOBILE=500;
var MAX_HEIGHT_DESKTOP=240;
var MAX_WIDTH_DESKTOP=575;

function getMobileSize(){return __bodyWrapper(this,arguments,function(){

if(feature('dialog_resize_refactor',false)){
var info=DOM.getViewportInfo();
if(info.height && info.width){
return {
width:Math.min(info.width,MAX_WIDTH_MOBILE),
height:Math.min(info.height,MAX_HEIGHT_MOBILE)};}}



return null;},{returns:'?object'});}__annotator(getMobileSize,{'module':'sdk.Dialog','line':27,'column':0,'endLine':39,'endColumn':1,'name':'getMobileSize'},{returns:'?object'});
















var SdkDialog=Type.extend({
constructor:__annotator(function SdkDialog(id,display){return __bodyWrapper(this,arguments,function(){
this.parent();
this.id = id;
this.display = display;

this._e2e = {};

if(!Dialog._dialogs){
Dialog._dialogs = {};
Dialog._addOrientationHandler();}

Dialog._dialogs[id] = this;
this.trackEvent('init');},{params:[[id,'string','id'],[display,'string','display']]});},{'module':'sdk.Dialog','line':56,'column':15,'endLine':69,'endColumn':3,'name':'SdkDialog'},{params:['string','string']}),


trackEvent:__annotator(function(name,time){return __bodyWrapper(this,arguments,function(){
if(this._e2e[name]){
return this;}

this._e2e[name] = time || ES('Date','now',false);
if(name == 'close'){

this.inform('e2e:end',this._e2e);}

return this;},{params:[[name,'string','name'],[time,'?number','time']],returns:'SdkDialog'});},{'module':'sdk.Dialog','line':71,'column':14,'endLine':81,'endColumn':3},{params:['string','?number'],returns:'SdkDialog'}),


trackEvents:__annotator(function(events){return __bodyWrapper(this,arguments,function(){
if(typeof events === 'string'){
events = ES('JSON','parse',false,events);}

for(var key in events) {
if(events.hasOwnProperty(key)){
this.trackEvent(key,events[key]);}}


return this;},{params:[[events,'string|object','events']],returns:'SdkDialog'});},{'module':'sdk.Dialog','line':83,'column':15,'endLine':93,'endColumn':3},{params:['string|object'],returns:'SdkDialog'})},

ObservableMixin);

var Dialog={
newInstance:__annotator(function(id,display){return __bodyWrapper(this,arguments,function(){
return new SdkDialog(id,display);},{params:[[id,'string','id'],[display,'string','display']],returns:'SdkDialog'});},{'module':'sdk.Dialog','line':97,'column':15,'endLine':99,'endColumn':3},{params:['string','string'],returns:'SdkDialog'}),





_dialogs:null,
_lastYOffset:0,
_overlayListeners:[],






_loaderEl:null,






_overlayEl:null,






_stack:[],






_active:null,






_forceTabletStyle:null,






_closeOnOverlayTap:null,






get:__annotator(function(id){return __bodyWrapper(this,arguments,function(){
return Dialog._dialogs[id];},{params:[[id,'string','id']],returns:'SdkDialog'});},{'module':'sdk.Dialog','line':155,'column':7,'endLine':157,'endColumn':3},{params:['string'],returns:'SdkDialog'}),











_findRoot:__annotator(function(node){return __bodyWrapper(this,arguments,function(){
while(node) {
if(DOM.containsCss(node,'fb_dialog')){
return node;}

node = node.parentNode;}},{params:[[node,'HTMLElement','node']],returns:'HTMLElement'});},{'module':'sdk.Dialog','line':168,'column':13,'endLine':175,'endColumn':3},{params:['HTMLElement'],returns:'HTMLElement'}),



_createWWWLoader:__annotator(function(width){return __bodyWrapper(this,arguments,function(){
width = width?width:460;
return Dialog.create({
content:
'<div class="dialog_title">' +
'  <a id="fb_dialog_loader_close">' +
'    <div class="fb_dialog_close_icon"></div>' +
'  </a>' +
'  <span>Facebook</span>' +
'  <div style="clear:both;"></div>' +
'</div>' +
'<div class="dialog_content"></div>' +
'<div class="dialog_footer"></div>',
width:width});},{params:[[width,'number','width']],returns:'HTMLElement'});},{'module':'sdk.Dialog','line':177,'column':20,'endLine':192,'endColumn':3},{params:['number'],returns:'HTMLElement'}),



_createMobileLoader:__annotator(function(){return __bodyWrapper(this,arguments,function(){





var content;
if(UA.nativeApp()){
content = '<div class="dialog_header"></div>';}else
if(Dialog.isTabletStyle()){
content =
'<div class="overlayLoader">' +
'<div id="fb_dialog_loader_spinner"></div>' +
'<a id="fb_dialog_loader_close" href="#">' + fbt._("Cancel") +

'</a>' +
'</div>';}else
{
content = '<div class="dialog_header">' +
'<table>' +
'  <tbody>' +
'    <tr>' +
'      <td class="header_left">' +
'        <label class="touchable_button">' +
'          <input type="submit" value="' + fbt._("Cancel") +

'"' +
'            id="fb_dialog_loader_close"/>' +
'        </label>' +
'      </td>' +
'      <td class="header_center">' +
'        <div>' +
'         ' + fbt._("Loading...") +

'        </div>' +
'      </td>' +
'      <td class="header_right">' +
'      </td>' +
'    </tr>' +
'  </tbody>' +
'</table>' +
'</div>';}

return Dialog.create({
classes:'loading' + (Dialog.isTabletStyle()?' centered':''),
content:content});},{returns:'HTMLElement'});},{'module':'sdk.Dialog','line':194,'column':23,'endLine':241,'endColumn':3},{returns:'HTMLElement'}),



_restoreBodyPosition:__annotator(function(){
var body=document.body;
if(Dialog.isTabletStyle()){
DOM.removeCss(body,'fb_reposition');}else
{
DOM.removeCss(body,'fb_hidden');}},{'module':'sdk.Dialog','line':243,'column':24,'endLine':250,'endColumn':3}),



_setDialogOverlayStyle:__annotator(function(){
if(!Dialog._overlayEl){
return;}


var view=DOM.getViewportInfo();


Dialog._overlayEl.style.minHeight = view.height || view.width?
view.height + 'px':
null;
Dialog._overlayEl.style.top = view.scrollTop?
view.scrollTop + 'px':
null;},{'module':'sdk.Dialog','line':252,'column':26,'endLine':266,'endColumn':3}),


_showTabletOverlay:__annotator(function(onClickForClose){return __bodyWrapper(this,arguments,function(){
if(!Dialog.isTabletStyle()){
return;}

if(!Dialog._overlayEl){
Dialog._overlayEl = document.createElement('div');
Dialog._overlayEl.setAttribute('id','fb_dialog_ipad_overlay');
Content.append(Dialog._overlayEl,null);}

Dialog._setDialogOverlayStyle();


if(Dialog._closeOnOverlayTap){
var closeAllowed=false;

setTimeout(__annotator(function(){return closeAllowed = true;},{'module':'sdk.Dialog','line':283,'column':17,'endLine':283,'endColumn':42}),3000);
var listener=DOMEventListener.add(
Dialog._overlayEl,
'click',__annotator(
function(){
if(closeAllowed){
onClickForClose();}},{'module':'sdk.Dialog','line':287,'column':8,'endLine':291,'endColumn':9}));



Dialog._overlayListeners.push(listener);}

Dialog._overlayEl.className = '';},{params:[[onClickForClose,'function','onClickForClose']]});},{'module':'sdk.Dialog','line':268,'column':22,'endLine':296,'endColumn':3},{params:['function']}),


_hideTabletOverlay:__annotator(function(){
if(Dialog.isTabletStyle()){
Dialog._overlayEl.className = 'hidden';
ES(Dialog._overlayListeners,'forEach',true,__annotator(function(listener){return listener.remove();},{'module':'sdk.Dialog','line':301,'column':39,'endLine':301,'endColumn':68}));
Dialog._overlayListeners = [];}},{'module':'sdk.Dialog','line':298,'column':22,'endLine':304,'endColumn':3}),










showLoader:__annotator(function(cb,width){return __bodyWrapper(this,arguments,function(){




if(!cb){
cb = __annotator(function(){},{'module':'sdk.Dialog','line':319,'column':11,'endLine':319,'endColumn':24});}


var onClick=__annotator(function(){
Dialog._hideLoader();
Dialog._restoreBodyPosition();
Dialog._hideTabletOverlay();
cb();},{'module':'sdk.Dialog','line':322,'column':18,'endLine':327,'endColumn':5});


Dialog._showTabletOverlay(onClick);

if(!Dialog._loaderEl){
Dialog._loaderEl = Dialog._findRoot(UA.mobile()?
Dialog._createMobileLoader():
Dialog._createWWWLoader(width));}


var loaderClose=document.getElementById('fb_dialog_loader_close');

if(loaderClose){
DOM.removeCss(loaderClose,'fb_hidden');
var listener=DOMEventListener.add(
loaderClose,
'click',
onClick);

Dialog._overlayListeners.push(listener);}


Dialog._makeActive(Dialog._loaderEl);},{params:[[cb,'?function','cb'],[width,'number','width']]});},{'module':'sdk.Dialog','line':313,'column':14,'endLine':350,'endColumn':3},{params:['?function','number']}),


setCloseOnOverlayTap:__annotator(function(val){return __bodyWrapper(this,arguments,function(){
Dialog._closeOnOverlayTap = !!val;},{params:[[val,'boolean','val']]});},{'module':'sdk.Dialog','line':352,'column':24,'endLine':354,'endColumn':3},{params:['boolean']}),






_hideLoader:__annotator(function(){
if(Dialog._loaderEl && Dialog._loaderEl == Dialog._active){
Dialog._loaderEl.style.top = '-10000px';}},{'module':'sdk.Dialog','line':360,'column':15,'endLine':364,'endColumn':3}),









_makeActive:__annotator(function(el){return __bodyWrapper(this,arguments,function(){
Dialog._setDialogSizes();
Dialog._lowerActive();
Dialog._active = el;
if(Runtime.isEnvironment(Runtime.ENVIRONMENTS.CANVAS)){
CanvasEnvironment.getPageInfo(__annotator(function(pageInfo){
Dialog._centerActive(pageInfo);},{'module':'sdk.Dialog','line':377,'column':36,'endLine':379,'endColumn':7}));}


Dialog._centerActive();},{params:[[el,'HTMLElement','el']]});},{'module':'sdk.Dialog','line':372,'column':15,'endLine':382,'endColumn':3},{params:['HTMLElement']}),





_lowerActive:__annotator(function(){
if(!Dialog._active){
return;}

Dialog._active.style.top = '-10000px';
Dialog._active = null;},{'module':'sdk.Dialog','line':387,'column':16,'endLine':393,'endColumn':3}),







_removeStacked:__annotator(function(dialog){return __bodyWrapper(this,arguments,function(){
Dialog._stack = ES(Dialog._stack,'filter',true,__annotator(function(node){
return node != dialog;},{'module':'sdk.Dialog','line':401,'column':41,'endLine':403,'endColumn':5}));},{params:[[dialog,'HTMLElement','dialog']]});},{'module':'sdk.Dialog','line':400,'column':18,'endLine':404,'endColumn':3},{params:['HTMLElement']}),







_centerActive:__annotator(function(pageInfo){return __bodyWrapper(this,arguments,function(){
var dialog=Dialog._active;
if(!dialog){
return;}


var view=DOM.getViewportInfo();
var width=parseInt(dialog.offsetWidth,10);
var height=parseInt(dialog.offsetHeight,10);
var left=view.scrollLeft + (view.width - width) / 2;








var minTop=(view.height - height) / 2.5;
if(left < minTop){
minTop = left;}

var maxTop=view.height - height - minTop;


var top=(view.height - height) / 2;
if(pageInfo){
top = pageInfo.scrollTop - pageInfo.offsetTop +
(pageInfo.clientHeight - height) / 2;}



if(top < minTop){
top = minTop;}else
if(top > maxTop){
top = maxTop;}



top += view.scrollTop;



if(UA.mobile()){



















var paddingHeight=100;



var body=document.body;
if(Dialog.isTabletStyle()){
paddingHeight += (view.height - height) / 2;
DOM.addCss(body,'fb_reposition');}else
{
DOM.addCss(body,'fb_hidden');
if(feature('dialog_resize_refactor',false)){
body.style.width = 'auto';}

top = 10000;}


var paddingDivs=DOM.getByClass('fb_dialog_padding',dialog);
if(paddingDivs.length){
paddingDivs[0].style.height = paddingHeight + 'px';}}



dialog.style.left = (left > 0?left:0) + 'px';
dialog.style.top = (top > 0?top:0) + 'px';},{params:[[pageInfo,'?object','pageInfo']]});},{'module':'sdk.Dialog','line':410,'column':17,'endLine':497,'endColumn':3},{params:['?object']}),


_setDialogSizes:__annotator(function(){var skipHeight=arguments.length <= 0 || arguments[0] === undefined?false:arguments[0];
if(!UA.mobile()){
return;}

for(var id in Dialog._dialogs) {
if(Dialog._dialogs.hasOwnProperty(id)){
var iframe=document.getElementById(id);
if(iframe){
iframe.style.width = Dialog.getDefaultSize().width + 'px';
if(!skipHeight){
iframe.style.height = Dialog.getDefaultSize().height + 'px';}}}}},{'module':'sdk.Dialog','line':499,'column':19,'endLine':514,'endColumn':3}),






getDefaultSize:__annotator(function(){return __bodyWrapper(this,arguments,function(){
if(UA.mobile()){
var size=getMobileSize();
if(size){
if(DOM.getViewportInfo().width <= size.width){
size.width = DOM.getViewportInfo().width - MARGIN_SURROUNDING;}

if(DOM.getViewportInfo().height <= size.height){
size.height = DOM.getViewportInfo().height - MARGIN_SURROUNDING;}

return size;}




if(UA.ipad()){
return {
width:MAX_WIDTH_MOBILE,
height:MAX_HEIGHT_MOBILE};}



if(UA.android()){


return {
width:screen.availWidth,
height:screen.availHeight};}else

{
var width=window.innerWidth;
var height=window.innerHeight;
var isLandscape=width / height > 1.2;











return {
width:width,
height:Math.max(height,
isLandscape?screen.width:screen.height)};}}



return {width:MAX_WIDTH_DESKTOP,height:MAX_HEIGHT_DESKTOP};},{returns:'object'});},{'module':'sdk.Dialog','line':516,'column':18,'endLine':568,'endColumn':3},{returns:'object'}),






_handleOrientationChange:__annotator(function(){

var screenWidth=feature('dialog_resize_refactor',false)?
DOM.getViewportInfo().width:
screen.availWidth;

Dialog._availScreenWidth = screenWidth;

if(Dialog.isTabletStyle()){

Dialog._setDialogSizes(true);
Dialog._centerActive();
Dialog._setDialogOverlayStyle();}else
{
var width=Dialog.getDefaultSize().width;
for(var id in Dialog._dialogs) {
if(Dialog._dialogs.hasOwnProperty(id)){

var iframe=document.getElementById(id);
if(iframe){
iframe.style.width = width + 'px';}}}}},{'module':'sdk.Dialog','line':574,'column':28,'endLine':599,'endColumn':3}),









_addOrientationHandler:__annotator(function(){
if(!UA.mobile()){
return;}




var event_name="onorientationchange" in window?
'orientationchange':
'resize';

Dialog._availScreenWidth = feature('dialog_resize_refactor',false)?
DOM.getViewportInfo().width:
screen.availWidth;

DOMEventListener.add(
window,
event_name,__annotator(


function(e){return setTimeout(Dialog._handleOrientationChange,50);},{'module':'sdk.Dialog','line':624,'column':6,'endLine':624,'endColumn':60}));},{'module':'sdk.Dialog','line':604,'column':26,'endLine':626,'endColumn':3}),




















create:__annotator(function(opts){return __bodyWrapper(this,arguments,function(){
opts = opts || {};

var
dialog=document.createElement('div'),
contentRoot=document.createElement('div'),
className='fb_dialog';


if(opts.closeIcon && opts.onClose){
var closeIcon=document.createElement('a');
closeIcon.className = 'fb_dialog_close_icon';
closeIcon.onclick = opts.onClose;
dialog.appendChild(closeIcon);}


className += ' ' + (opts.classes || '');


if(UA.ie()){
className += ' fb_dialog_legacy';
ES(['vert_left',
'vert_right',
'horiz_top',
'horiz_bottom',
'top_left',
'top_right',
'bottom_left',
'bottom_right'],'forEach',true,__annotator(function(name){return __bodyWrapper(this,arguments,function(){
var span=document.createElement('span');
span.className = 'fb_dialog_' + name;
dialog.appendChild(span);},{params:[[name,'string','name']]});},{'module':'sdk.Dialog','line':673,'column':32,'endLine':677,'endColumn':9},{params:['string']}));}else

{
className += UA.mobile()?
' fb_dialog_mobile':
' fb_dialog_advanced';}


if(opts.content){
Content.append(opts.content,contentRoot);}

dialog.className = className;
var width=parseInt(opts.width,10);
if(!isNaN(width)){
dialog.style.width = width + 'px';}

contentRoot.className = 'fb_dialog_content';

dialog.appendChild(contentRoot);
if(UA.mobile()){
var padding=document.createElement('div');
padding.className = 'fb_dialog_padding';
dialog.appendChild(padding);}


Content.append(dialog);

if(opts.visible){
Dialog.show(dialog);}

return contentRoot;},{params:[[opts,'object','opts']],returns:'HTMLElement'});},{'module':'sdk.Dialog','line':645,'column':10,'endLine':707,'endColumn':3},{params:['object'],returns:'HTMLElement'}),










show:__annotator(function(dialog){return __bodyWrapper(this,arguments,function(){
var root=Dialog._findRoot(dialog);
if(root){
Dialog._removeStacked(root);
Dialog._hideLoader();
Dialog._makeActive(root);
Dialog._stack.push(root);
if('fbCallID' in dialog){
Dialog.get(dialog.fbCallID).
inform('iframe_show').
trackEvent('show');}}},{params:[[dialog,'HTMLElement','dialog']]});},{'module':'sdk.Dialog','line':717,'column':8,'endLine':730,'endColumn':3},{params:['HTMLElement']}),










hide:__annotator(function(dialog){return __bodyWrapper(this,arguments,function(){
var root=Dialog._findRoot(dialog);
Dialog._hideLoader();
if(root == Dialog._active){
Dialog._lowerActive();
Dialog._restoreBodyPosition();
Dialog._hideTabletOverlay();
if('fbCallID' in dialog){
Dialog.get(dialog.fbCallID).
inform('iframe_hide').
trackEvent('hide');}}},{params:[[dialog,'HTMLElement','dialog']]});},{'module':'sdk.Dialog','line':738,'column':8,'endLine':751,'endColumn':3},{params:['HTMLElement']}),









remove:__annotator(function(dialog){return __bodyWrapper(this,arguments,function(){
dialog = Dialog._findRoot(dialog);
if(dialog){
var is_active=Dialog._active == dialog;
Dialog._removeStacked(dialog);
if(is_active){
Dialog._hideLoader();
if(Dialog._stack.length > 0){
Dialog.show(Dialog._stack.pop());}else
{
Dialog._lowerActive();
Dialog._restoreBodyPosition();
Dialog._hideTabletOverlay();}}else

if(Dialog._active === null && Dialog._stack.length > 0){
Dialog.show(Dialog._stack.pop());}








setTimeout(__annotator(function(){
dialog.parentNode.removeChild(dialog);},{'module':'sdk.Dialog','line':782,'column':17,'endLine':784,'endColumn':7}),
3000);}},{params:[[dialog,'HTMLElement','dialog']]});},{'module':'sdk.Dialog','line':758,'column':10,'endLine':786,'endColumn':3},{params:['HTMLElement']}),








isActive:__annotator(function(node){return __bodyWrapper(this,arguments,function(){
var root=Dialog._findRoot(node);
return root && root === Dialog._active;},{params:[[node,'HTMLElement','node']],returns:'boolean'});},{'module':'sdk.Dialog','line':793,'column':12,'endLine':796,'endColumn':3},{params:['HTMLElement'],returns:'boolean'}),


setForceTabletStyle:__annotator(function(val){return __bodyWrapper(this,arguments,function(){
Dialog._forceTabletStyle = !!val;},{params:[[val,'boolean','val']]});},{'module':'sdk.Dialog','line':798,'column':23,'endLine':800,'endColumn':3},{params:['boolean']}),


isTabletStyle:__annotator(function(){return __bodyWrapper(this,arguments,function(){
var result;
if(!UA.mobile()){
return false;}

if(Dialog._forceTabletStyle){
return true;}

if(feature('dialog_resize_refactor',false)){
var size=getMobileSize();
result = size && (
size.height >= MAX_HEIGHT_MOBILE || size.width >= MAX_WIDTH_MOBILE);}else
{
result = !!UA.ipad();}

return result;},{returns:'boolean'});},{'module':'sdk.Dialog','line':802,'column':17,'endLine':818,'endColumn':3},{returns:'boolean'})};



module.exports = Dialog;},{'module':'sdk.Dialog','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Dialog'}),null);

__d('sdk.Frictionless',['sdk.Auth','sdk.api','sdk.Event','sdk.Dialog'],__annotator(function $module_sdk_Frictionless(global,require,requireDynamic,requireLazy,module,exports,Auth,api,Event,Dialog){if(require.__markCompiled)require.__markCompiled();






var Frictionless={



_allowedRecipients:{},

_useFrictionless:false,




_updateRecipients:__annotator(function(){
Frictionless._allowedRecipients = {};
api('/me/apprequestformerrecipients',__annotator(function(response){
if(!response || response.error){
return;}

ES(response.data,'forEach',true,__annotator(function(recipient){return __bodyWrapper(this,arguments,function(){
Frictionless._allowedRecipients[recipient.recipient_id] = true;},{params:[[recipient,'object','recipient']]});},{'module':'sdk.Frictionless','line':30,'column':28,'endLine':32,'endColumn':7},{params:['object']}));},{'module':'sdk.Frictionless','line':26,'column':42,'endLine':33,'endColumn':5}));},{'module':'sdk.Frictionless','line':24,'column':21,'endLine':34,'endColumn':3}),







init:__annotator(function(){
Frictionless._useFrictionless = true;
Auth.getLoginStatus(__annotator(function(response){return __bodyWrapper(this,arguments,function(){
if(response.status == 'connected'){
Frictionless._updateRecipients();}},{params:[[response,'object','response']]});},{'module':'sdk.Frictionless','line':41,'column':24,'endLine':45,'endColumn':5},{params:['object']}));


Event.subscribe('auth.login',__annotator(function(login){return __bodyWrapper(this,arguments,function(){
if(login.authResponse){
Frictionless._updateRecipients();}},{params:[[login,'object','login']]});},{'module':'sdk.Frictionless','line':46,'column':34,'endLine':50,'endColumn':5},{params:['object']}));},{'module':'sdk.Frictionless','line':39,'column':8,'endLine':51,'endColumn':3}),











_processRequestResponse:__annotator(function(cb,hidden){return __bodyWrapper(this,arguments,function()
{
return __annotator(function(params){
var updated=params && params.updated_frictionless;
if(Frictionless._useFrictionless && updated){


Frictionless._updateRecipients();}


if(params){
if(!hidden && params.frictionless){
Dialog._hideLoader();
Dialog._restoreBodyPosition();
Dialog._hideIPadOverlay();}

delete params.frictionless;
delete params.updated_frictionless;}


cb && cb(params);},{'module':'sdk.Frictionless','line':62,'column':11,'endLine':81,'endColumn':5});},{params:[[cb,'function','cb']],returns:'function'});},{'module':'sdk.Frictionless','line':60,'column':27,'endLine':82,'endColumn':3},{params:['function'],returns:'function'}),










isAllowed:__annotator(function(user_ids){return __bodyWrapper(this,arguments,function(){
if(!user_ids){
return false;}


if(typeof user_ids === 'number'){
return user_ids in Frictionless._allowedRecipients;}

if(typeof user_ids === 'string'){
user_ids = user_ids.split(',');}

user_ids = ES(user_ids,'map',true,__annotator(function(s){return ES(String(s),'trim',true);},{'module':'sdk.Frictionless','line':102,'column':28,'endLine':102,'endColumn':66}));

var allowed=true;
var has_user_ids=false;
ES(user_ids,'forEach',true,__annotator(function(user_id){return __bodyWrapper(this,arguments,function(){
allowed = allowed && user_id in Frictionless._allowedRecipients;
has_user_ids = true;},{params:[[user_id,'string','user_id']]});},{'module':'sdk.Frictionless','line':106,'column':21,'endLine':109,'endColumn':5},{params:['string']}));

return allowed && has_user_ids;},{returns:'boolean'});},{'module':'sdk.Frictionless','line':91,'column':13,'endLine':111,'endColumn':3},{returns:'boolean'})};



Event.subscribe('init:post',__annotator(function(options){return __bodyWrapper(this,arguments,function(){
if(options.frictionlessRequests){
Frictionless.init();}},{params:[[options,'object','options']]});},{'module':'sdk.Frictionless','line':114,'column':29,'endLine':118,'endColumn':1},{params:['object']}));




module.exports = Frictionless;},{'module':'sdk.Frictionless','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Frictionless'}),null);

__d('sdk.Native',['Log','sdk.UA'],__annotator(function $module_sdk_Native(global,require,requireDynamic,requireLazy,module,exports,Log,UA){if(require.__markCompiled)require.__markCompiled();




var NATIVE_READY_EVENT='fbNativeReady';

var Native={







onready:__annotator(function(func){return __bodyWrapper(this,arguments,function(){

if(!UA.nativeApp()){
Log.error('FB.Native.onready only works when the page is rendered ' +
'in a WebView of the native Facebook app. Test if this is the ' +
'case calling FB.UA.nativeApp()');
return;}






if(window.__fbNative && !this.nativeReady){
ES('Object','assign',false,this,window.__fbNative);}



if(this.nativeReady){
func();}else
{


var nativeReadyCallback=__annotator(function(evt){
window.removeEventListener(NATIVE_READY_EVENT,nativeReadyCallback);
this.onready(func);},{'module':'sdk.Native','line':44,'column':32,'endLine':47,'endColumn':7});

window.addEventListener(NATIVE_READY_EVENT,nativeReadyCallback,false);}},{params:[[func,'function','func']]});},{'module':'sdk.Native','line':21,'column':11,'endLine':50,'endColumn':3},{params:['function']})};




module.exports = Native;},{'module':'sdk.Native','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Native'}),null);

__d('sdk.UIServer',['sdk.Auth','sdk.Content','sdk.DOM','sdk.Dialog','sdk.Event','sdk.Frictionless','Log','sdk.Native','QueryString','sdk.RPC','sdk.Runtime','JSSDKConfig','sdk.UA','UrlMap','sdk.XD','createObjectFrom','sdk.feature','sdk.fbt','flattenObject','sdk.getContextType','guid','insertIframe','resolveURI'],__annotator(function $module_sdk_UIServer(global,require,requireDynamic,requireLazy,module,exports,Auth,Content,DOM,Dialog,Event,Frictionless,Log,Native,QueryString,RPC,Runtime,SDKConfig,UA,UrlMap,XD,createObjectFrom,feature,fbt,flattenObject,getContextType,guid,insertIframe,resolveURI){if(require.__markCompiled)require.__markCompiled();


























var MobileIframeable={
transform:__annotator(function(call){return __bodyWrapper(this,arguments,function(){



if(call.params.display === 'touch' &&
UIServer.canIframe(call.params) &&
window.postMessage)
{


call.params.channel = UIServer._xdChannelHandler(
call.id,
'parent');


if(!UA.nativeApp()){
call.params.in_iframe = 1;}

return call;}else
{
return UIServer.genericTransform(call);}},{params:[[call,'object','call']],returns:'object'});},{'module':'sdk.UIServer','line':37,'column':11,'endLine':59,'endColumn':3},{params:['object'],returns:'object'}),


getXdRelation:__annotator(function(params){return __bodyWrapper(this,arguments,function(){
var display=params.display;
if(display === 'touch' && window.postMessage && params.in_iframe){



return 'parent';}

return UIServer.getXdRelation(params);},{params:[[params,'object','params']],returns:'string'});},{'module':'sdk.UIServer','line':60,'column':15,'endLine':69,'endColumn':3},{params:['object'],returns:'string'})};



var Methods={
'stream.share':{
size:{width:670,height:340},
url:'sharer.php',
transform:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
if(!call.params.u){
call.params.u = window.location.toString();}

call.params.display = 'popup';
return call;},{params:[[call,'object','call']],returns:'object'});},{'module':'sdk.UIServer','line':76,'column':13,'endLine':82,'endColumn':5},{params:['object'],returns:'object'})},




'apprequests':{
transform:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
call = MobileIframeable.transform(call);

call.params.frictionless = Frictionless &&
Frictionless._useFrictionless;
if(call.params.frictionless){

if(Frictionless.isAllowed(call.params.to)){




call.params.display = 'iframe';
call.params.in_iframe = true;

call.hideLoader = true;}



call.cb = Frictionless._processRequestResponse(
call.cb,
call.hideLoader);}




call.closeIcon = false;
return call;},{params:[[call,'object','call']],returns:'object'});},{'module':'sdk.UIServer','line':87,'column':13,'endLine':115,'endColumn':5},{params:['object'],returns:'object'}),

getXdRelation:MobileIframeable.getXdRelation},


'feed':MobileIframeable,

'permissions.oauth':{
url:'dialog/oauth',
size:{width:UA.mobile()?null:475,
height:UA.mobile()?null:183},
transform:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
if(!Runtime.getClientID()){
Log.error('FB.login() called before FB.init().');
return;}





if(Auth.getAuthResponse() &&
!call.params.scope &&
!call.params.auth_type){
Log.error('FB.login() called when user is already connected.');
call.cb && call.cb({status:Runtime.getLoginStatus(),
authResponse:Auth.getAuthResponse()});
return;}


var
cb=call.cb,
id=call.id;
delete call.cb;

var responseTypes=ES('Object','keys',false,ES('Object','assign',false,
call.params.response_type?
createObjectFrom(call.params.response_type.split(',')):
{},
{token:true,signed_request:true})).
join(',');

if(call.params.display === 'async'){
ES('Object','assign',false,
call.params,{
client_id:Runtime.getClientID(),
origin:getContextType(),
response_type:responseTypes,
domain:location.hostname});


call.cb = Auth.xdResponseWrapper(
cb,Auth.getAuthResponse(),'permissions.oauth');}else
{
ES('Object','assign',false,
call.params,{
client_id:Runtime.getClientID(),
redirect_uri:resolveURI(
UIServer.xdHandler(
cb,
id,
'opener',
Auth.getAuthResponse(),
'permissions.oauth')),
origin:getContextType(),
response_type:responseTypes,
domain:location.hostname});}



return call;},{params:[[call,'object','call']],returns:'?object'});},{'module':'sdk.UIServer','line':125,'column':13,'endLine':184,'endColumn':5},{params:['object'],returns:'?object'})},



'auth.logout':{
url:'logout.php',
transform:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
if(!Runtime.getClientID()){
Log.error('FB.logout() called before calling FB.init().');}else
if(!Auth.getAuthResponse()){
Log.error('FB.logout() called without an access token.');}else
{
call.params.next = UIServer.xdHandler(call.cb,
call.id,
'parent',
Auth.getAuthResponse(),
'logout');
return call;}},{params:[[call,'object','call']],returns:'?object'});},{'module':'sdk.UIServer','line':189,'column':13,'endLine':202,'endColumn':5},{params:['object'],returns:'?object'})},




'login.status':{
url:'dialog/oauth',
transform:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
var
cb=call.cb,
id=call.id;
delete call.cb;
ES('Object','assign',false,call.params,{
client_id:Runtime.getClientID(),
redirect_uri:UIServer.xdHandler(cb,
id,
'parent',
Auth.getAuthResponse(),
'login_status'),
origin:getContextType(),
response_type:'token,signed_request,code',
domain:location.hostname});


return call;},{params:[[call,'object','call']],returns:'object'});},{'module':'sdk.UIServer','line':207,'column':13,'endLine':225,'endColumn':5},{params:['object'],returns:'object'})},



'pay':{
size:{width:555,height:120},
connectDisplay:'popup'}};







var _dialogStates={};

function _trackRunState(cb,id){return __bodyWrapper(this,arguments,function(){
_dialogStates[id] = true;
return __annotator(function(response){
delete _dialogStates[id];
cb(response);},{'module':'sdk.UIServer','line':242,'column':9,'endLine':245,'endColumn':3});},{params:[[cb,'function','cb'],[id,'string','id']]});}__annotator(_trackRunState,{'module':'sdk.UIServer','line':240,'column':0,'endLine':246,'endColumn':1,'name':'_trackRunState'},{params:['function','string']});







function shouldEnforceSingleDialogInstance(params){

if(!feature('should_force_single_dialog_instance',true)){
return false;}



var name=params.method.toLowerCase();


if(name === 'pay' && params.display === 'async'){
return true;}


return false;}__annotator(shouldEnforceSingleDialogInstance,{'module':'sdk.UIServer','line':252,'column':0,'endLine':267,'endColumn':1,'name':'shouldEnforceSingleDialogInstance'});


var UIServer={



Methods:Methods,

_loadedNodes:{},
_defaultCb:{},
_resultToken:'"xxRESULTTOKENxx"',










genericTransform:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
if(call.params.display == 'dialog' || call.params.display == 'iframe'){
ES('Object','assign',false,call.params,{
display:'iframe',
channel:UIServer._xdChannelHandler(call.id,'parent.parent')},
true);}


return call;},{params:[[call,'object','call']],returns:'object'});},{'module':'sdk.UIServer','line':288,'column':18,'endLine':297,'endColumn':3},{params:['object'],returns:'object'}),






checkOauthDisplay:__annotator(function(params){
var scope=params.scope || params.perms || Runtime.getScope();
if(!scope){
return params.display;}


var scopes=scope.split(/\s|,/g);
for(var ii=0;ii < scopes.length;ii++) {
if(!SDKConfig.initSitevars.iframePermissions[ES(scopes[ii],'trim',true)]){
return 'popup';}}



return params.display;},{'module':'sdk.UIServer','line':303,'column':19,'endLine':317,'endColumn':3}),










prepareCall:__annotator(function(params,cb){return __bodyWrapper(this,arguments,function(){
var
name=params.method.toLowerCase(),
method=UIServer.Methods.hasOwnProperty(name)?ES('Object','assign',false,
{},UIServer.Methods[name]):
{},
id=guid(),
useSSL=Runtime.getSecure() ||
name !== 'auth.status' && name != 'login.status';


ES('Object','assign',false,params,{
app_id:Runtime.getClientID(),
locale:Runtime.getLocale(),
sdk:'joey',
access_token:useSSL && Runtime.getAccessToken() || undefined});



if(name === 'share' || name === 'share_open_graph'){
if(params.iframe_test){
method = ES('Object','assign',false,{},MobileIframeable);}}




params.display = UIServer.getDisplayMode(method,params);


if(!method.url){
method.url = 'dialog/' + name;}


if((method.url == 'dialog/oauth' ||
method.url == 'dialog/permissions.request') && (
params.display == 'iframe' ||
params.display == 'touch' && params.in_iframe)){
params.display = UIServer.checkOauthDisplay(params);}




if(params.display == 'popup'){
delete params.access_token;}


if(Runtime.getIsVersioned() && method.url.substring(0,7) === 'dialog/'){
method.url = params.version + '/' + method.url;}


if(shouldEnforceSingleDialogInstance(params)){

if(_dialogStates[name]){
var errorMessage='Dialog "' + name +
'" is trying to run more than once.';
Log.warn(errorMessage);
cb({error_code:-100,error_message:errorMessage});
return;}


cb = _trackRunState(cb,name);}



var call={
cb:cb,
id:id,
size:method.size || UIServer.getDefaultSize(),
url:UrlMap.resolve(params.display == 'touch'?'m':'www',useSSL) +
'/' + method.url,
params:params,
name:name,
dialog:Dialog.newInstance(id,params.display)};



var transform=method.transform?
method.transform:
UIServer.genericTransform;
if(transform){
call = transform(call);


if(!call){
return;}}




if(params.display === 'touch' && params.in_iframe){







call.params.parent_height = window.innerHeight;}




var getXdRelationFn=method.getXdRelation || UIServer.getXdRelation;
var relation=getXdRelationFn(call.params);
if(!(call.id in UIServer._defaultCb) &&
!('next' in call.params) &&
!('redirect_uri' in call.params)){
call.params.next = UIServer._xdResult(
call.cb,
call.id,
relation,
true);}


if(relation === 'parent'){
ES('Object','assign',false,call.params,{
channel_url:UIServer._xdChannelHandler(id,'parent.parent')},
true);}



call = UIServer.prepareParams(call);

return call;},{params:[[params,'object','params'],[cb,'function','cb']],returns:'?object'});},{'module':'sdk.UIServer','line':327,'column':13,'endLine':451,'endColumn':3},{params:['object','function'],returns:'?object'}),


prepareParams:__annotator(function(call){return __bodyWrapper(this,arguments,function(){




if(call.params.display !== 'async'){
delete call.params.method;}



call.params = flattenObject(call.params);
var encodedQS=QueryString.encode(call.params);




if(!UA.nativeApp() &&
UIServer.urlTooLongForIE(call.url + '?' + encodedQS)){
call.post = true;}else
if(encodedQS){
call.url += '?' + encodedQS;}


return call;},{params:[[call,'object','call']],returns:'object'});},{'module':'sdk.UIServer','line':453,'column':15,'endLine':477,'endColumn':3},{params:['object'],returns:'object'}),


urlTooLongForIE:__annotator(function(fullURL){return __bodyWrapper(this,arguments,function(){
return UA.ie() && UA.ie() <= 8 && fullURL.length > 2048;},{params:[[fullURL,'string','fullURL']],returns:'boolean'});},{'module':'sdk.UIServer','line':479,'column':17,'endLine':481,'endColumn':3},{params:['string'],returns:'boolean'}),









getDisplayMode:__annotator(function(method,params){return __bodyWrapper(this,arguments,function(){
if(params.display === 'hidden' ||
params.display === 'none'){
return params.display;}


var canvas=Runtime.isEnvironment(Runtime.ENVIRONMENTS.CANVAS) ||
Runtime.isEnvironment(Runtime.ENVIRONMENTS.PAGETAB);
if(canvas && !params.display){
return 'async';}



if(UA.mobile() && params.method !== 'feed' ||
params.display === 'touch'){
return 'touch';}



if(params.display == 'iframe' || params.display == 'dialog'){
if(!UIServer.canIframe(params)){
Log.error('"dialog" mode can only be used when the user is connected.');
return 'popup';}}



if(method.connectDisplay && !canvas){
return method.connectDisplay;}



return params.display || (UIServer.canIframe(params)?'dialog':'popup');},{params:[[method,'object','method'],[params,'object','params']],returns:'string'});},{'module':'sdk.UIServer','line':490,'column':16,'endLine':522,'endColumn':3},{params:['object','object'],returns:'string'}),


canIframe:__annotator(function(params){return __bodyWrapper(this,arguments,function(){
if(Runtime.getAccessToken()){
return true;}



if(UA.mobile() && Runtime.getLoggedIntoFacebook()){
return !!params.iframe_test;}

return false;},{params:[[params,'object','params']],returns:'boolean'});},{'module':'sdk.UIServer','line':524,'column':11,'endLine':534,'endColumn':3},{params:['object'],returns:'boolean'}),








getXdRelation:__annotator(function(params){return __bodyWrapper(this,arguments,function(){
var display=params.display;
if(display === 'popup' || display === 'touch'){
return 'opener';}

if(display === 'dialog' || display === 'iframe' ||
display === 'hidden' || display === 'none'){
return 'parent';}

if(display === 'async'){
return 'parent.frames[' + window.name + ']';}},{params:[[params,'object','params']],returns:'string'});},{'module':'sdk.UIServer','line':542,'column':15,'endLine':554,'endColumn':3},{params:['object'],returns:'string'}),









popup:__annotator(function(call){return __bodyWrapper(this,arguments,function(){

var
_screenX=typeof window.screenX != 'undefined'?
window.screenX:
window.screenLeft,
screenY=typeof window.screenY != 'undefined'?
window.screenY:
window.screenTop,
outerWidth=typeof window.outerWidth != 'undefined'?
window.outerWidth:
document.documentElement.clientWidth,
outerHeight=typeof window.outerHeight != 'undefined'?
window.outerHeight:
document.documentElement.clientHeight - 22,



width=UA.mobile()?null:call.size.width,
height=UA.mobile()?null:call.size.height,
screenX=_screenX < 0?window.screen.width + _screenX:_screenX,
left=parseInt(screenX + (outerWidth - width) / 2,10),
top=parseInt(screenY + (outerHeight - height) / 2.5,10),
features=[];

if(width !== null){
features.push('width=' + width);}

if(height !== null){
features.push('height=' + height);}

features.push('left=' + left);
features.push('top=' + top);
features.push('scrollbars=1');
if(call.name == 'permissions.request' ||
call.name == 'permissions.oauth'){
features.push('location=1,toolbar=0');}

features = features.join(',');


var popup;
if(call.post){
popup = window.open('about:blank',call.id,features);
if(popup){
UIServer.setLoadedNode(call,popup,'popup');
Content.submitToTarget({
url:call.url,
target:call.id,
params:call.params});}}else


{
popup = window.open(call.url,call.id,features);
if(popup){
UIServer.setLoadedNode(call,popup,'popup');}}




if(!popup){

return;}



if(call.id in UIServer._defaultCb){
UIServer._popupMonitor();}},{params:[[call,'object','call']]});},{'module':'sdk.UIServer','line':562,'column':7,'endLine':631,'endColumn':3},{params:['object']}),



setLoadedNode:__annotator(function(call,node,type){return __bodyWrapper(this,arguments,function(){
if(type === 'iframe'){
node.fbCallID = call.id;}

node = {
node:node,
type:type,
fbCallID:call.id};

UIServer._loadedNodes[call.id] = node;},{params:[[call,'object','call'],[type,'?string','type']]});},{'module':'sdk.UIServer','line':633,'column':15,'endLine':643,'endColumn':3},{params:['object','?string']}),


getLoadedNode:__annotator(function(call){
var id=typeof call == 'object'?call.id:call,
node=UIServer._loadedNodes[id];
return node?node.node:null;},{'module':'sdk.UIServer','line':645,'column':15,'endLine':649,'endColumn':3}),







hidden:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
call.className = 'FB_UI_Hidden';
call.root = Content.appendHidden('');
UIServer._insertIframe(call);},{params:[[call,'object','call']]});},{'module':'sdk.UIServer','line':656,'column':8,'endLine':660,'endColumn':3},{params:['object']}),







iframe:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
call.className = 'FB_UI_Dialog';
if(call.params.iframe_test){
Dialog.setForceTabletStyle(true);
Dialog.setCloseOnOverlayTap(true);}

var onClose=__annotator(function(){
var errorResult=ES('JSON','stringify',false,{

error_code:4201,
error_message:fbt._("User canceled the Dialog flow")});




UIServer._triggerDefault(call.id,errorResult);},{'module':'sdk.UIServer','line':673,'column':18,'endLine':683,'endColumn':5});

call.root = Dialog.create({
onClose:onClose,
closeIcon:call.closeIcon === undefined?true:call.closeIcon,
classes:Dialog.isTabletStyle()?'centered':''});

if(!call.hideLoader){
Dialog.showLoader(onClose,call.size.width);}

DOM.addCss(call.root,'fb_dialog_iframe');
UIServer._insertIframe(call);},{params:[[call,'object','call']]});},{'module':'sdk.UIServer','line':667,'column':8,'endLine':694,'endColumn':3},{params:['object']}),








touch:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
if(call.params && call.params.in_iframe){


if(call.ui_created){
Dialog.showLoader(__annotator(function(){
UIServer._triggerDefault(call.id,null);},{'module':'sdk.UIServer','line':707,'column':26,'endLine':709,'endColumn':9}),
0);}else
{
UIServer.iframe(call);}}else

if(UA.nativeApp() && !call.ui_created){


call.frame = call.id;
Native.onready(__annotator(function(){






UIServer.setLoadedNode(
call,
Native.open(call.url + '#cb=' + call.frameName),
'native');},{'module':'sdk.UIServer','line':717,'column':21,'endLine':728,'endColumn':7}));

UIServer._popupMonitor();}else
if(!call.ui_created){

UIServer.popup(call);}},{params:[[call,'object','call']]});},{'module':'sdk.UIServer','line':702,'column':7,'endLine':734,'endColumn':3},{params:['object']}),










async:__annotator(function(call){return __bodyWrapper(this,arguments,function(){
call.params.redirect_uri = location.protocol + '//' +
location.host + location.pathname;
delete call.params.access_token;

RPC.remote.showDialog(
call.params,__annotator(

function(response){return __bodyWrapper(this,arguments,function(){
var result=response.result;

if(result && result.e2e){
var dialog=Dialog.get(call.id);
dialog.trackEvents(result.e2e);
dialog.trackEvent('close');
delete result.e2e;}

call.cb(result);},{params:[[response,'object','response']]});},{'module':'sdk.UIServer','line':751,'column':6,'endLine':761,'endColumn':7},{params:['object']}));},{params:[[call,'object','call']]});},{'module':'sdk.UIServer','line':743,'column':7,'endLine':763,'endColumn':3},{params:['object']}),




getDefaultSize:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return Dialog.getDefaultSize();},{returns:'object'});},{'module':'sdk.UIServer','line':765,'column':16,'endLine':767,'endColumn':3},{returns:'object'}),







_insertIframe:__annotator(function(call){return __bodyWrapper(this,arguments,function(){



UIServer._loadedNodes[call.id] = false;
var activate=__annotator(function(node){return __bodyWrapper(this,arguments,function(){
if(call.id in UIServer._loadedNodes){
UIServer.setLoadedNode(call,node,'iframe');}},{params:[[node,'HTMLElement','node']]});},{'module':'sdk.UIServer','line':779,'column':19,'endLine':783,'endColumn':5},{params:['HTMLElement']});




if(call.post){
insertIframe({
url:'about:blank',
root:call.root,
className:call.className,
width:call.size.width,
height:call.size.height,
id:call.id,
onInsert:activate,
onload:__annotator(function(node){return __bodyWrapper(this,arguments,function(){
Content.submitToTarget({
url:call.url,
target:node.name,
params:call.params});},{params:[[node,'HTMLElement','node']]});},{'module':'sdk.UIServer','line':795,'column':20,'endLine':801,'endColumn':9},{params:['HTMLElement']})});}else



{
insertIframe({
url:call.url,
root:call.root,
className:call.className,
width:call.size.width,
height:call.size.height,
id:call.id,
name:call.frameName,
onInsert:activate});}},{params:[[call,'object','call']]});},{'module':'sdk.UIServer','line':774,'column':15,'endLine':815,'endColumn':3},{params:['object']}),









_handleResizeMessage:__annotator(function(frame,data){return __bodyWrapper(this,arguments,function(){
var node=UIServer.getLoadedNode(frame);
if(!node){
return;}


if(data.height){
node.style.height = data.height + 'px';}

if(data.width){
node.style.width = data.width + 'px';}


XD.inform(
'resize.ack',
data || {},
'parent.frames[' + node.name + ']');

if(!Dialog.isActive(node)){
Dialog.show(node);}else
{
Dialog._centerActive();}},{params:[[frame,'string','frame'],[data,'object','data']]});},{'module':'sdk.UIServer','line':822,'column':22,'endLine':845,'endColumn':3},{params:['string','object']}),









_triggerDefault:__annotator(function(id,result){return __bodyWrapper(this,arguments,function(){
var data={frame:id};
if(result){
data.result = result;}

UIServer._xdRecv(
data,
UIServer._defaultCb[id] || __annotator(function(){},{'module':'sdk.UIServer','line':860,'column':33,'endLine':860,'endColumn':46}));},{params:[[id,'string','id'],[result,'?string','result']]});},{'module':'sdk.UIServer','line':853,'column':17,'endLine':862,'endColumn':3},{params:['string','?string']}),









_popupMonitor:__annotator(function(){

var found;
for(var id in UIServer._loadedNodes) {

if(UIServer._loadedNodes.hasOwnProperty(id) &&
id in UIServer._defaultCb){
var node=UIServer._loadedNodes[id];
if(node.type != 'popup' && node.type != 'native'){
continue;}

var win=node.node;

try{

if(win.closed){
UIServer._triggerDefault(id,null);}else
{
found = true;}}

catch(y) {}}}





if(found && !UIServer._popupInterval){

UIServer._popupInterval = setInterval(UIServer._popupMonitor,100);}else
if(!found && UIServer._popupInterval){

clearInterval(UIServer._popupInterval);
UIServer._popupInterval = null;}},{'module':'sdk.UIServer','line':870,'column':15,'endLine':904,'endColumn':3}),











_xdChannelHandler:__annotator(function(frame,relation){return __bodyWrapper(this,arguments,function()
{
return XD.handler(__annotator(function(data){return __bodyWrapper(this,arguments,function(){
var node=UIServer.getLoadedNode(frame);
if(!node){
return;}


if(data.type == 'resize'){
UIServer._handleResizeMessage(frame,data);}else
if(data.type == 'hide'){
Dialog.hide(node);}else
if(data.type == 'rendered'){
var root=Dialog._findRoot(node);
Dialog.show(root);}else
if(data.type == 'fireevent'){
Event.fire(data.event);}},{params:[[data,'object','data']]});},{'module':'sdk.UIServer','line':916,'column':22,'endLine':932,'endColumn':5},{params:['object']}),

relation,true,null);},{params:[[frame,'string','frame'],[relation,'string','relation']],returns:'string'});},{'module':'sdk.UIServer','line':914,'column':19,'endLine':933,'endColumn':3},{params:['string','string'],returns:'string'}),













_xdNextHandler:__annotator(function(cb,frame,
relation,isDefault){return __bodyWrapper(this,arguments,function(){
if(isDefault){
UIServer._defaultCb[frame] = cb;}


return XD.handler(__annotator(function(data){
UIServer._xdRecv(data,cb);},{'module':'sdk.UIServer','line':952,'column':22,'endLine':954,'endColumn':5}),
relation) + '&frame=' + frame;},{params:[[cb,'function','cb'],[frame,'string','frame'],[relation,'string','relation'],[isDefault,'boolean','isDefault']],returns:'string'});},{'module':'sdk.UIServer','line':946,'column':16,'endLine':955,'endColumn':3},{params:['function','string','string','boolean'],returns:'string'}),










_xdRecv:__annotator(function(data,cb){return __bodyWrapper(this,arguments,function(){
var frame=UIServer.getLoadedNode(data.frame);
if(frame){
if(frame.close){

try{
frame.close();



if(/iPhone.*Version\/(5|6)/.test(navigator.userAgent) &&
RegExp.$1 !== '5'){
window.focus();}

UIServer._popupCount--;}
catch(y) {}}else


{

if(DOM.containsCss(frame,'FB_UI_Hidden')){


setTimeout(__annotator(function(){

frame.parentNode.parentNode.removeChild(frame.parentNode);},{'module':'sdk.UIServer','line':988,'column':21,'endLine':991,'endColumn':11}),
3000);}else
if(DOM.containsCss(frame,'FB_UI_Dialog')){
Dialog.remove(frame);}}}




delete UIServer._loadedNodes[data.frame];
delete UIServer._defaultCb[data.frame];

if(data.e2e){
var dialog=Dialog.get(data.frame);
dialog.trackEvents(data.e2e);
dialog.trackEvent('close');
delete data.e2e;}

cb(data);},{params:[[data,'object','data'],[cb,'function','cb']]});},{'module':'sdk.UIServer','line':965,'column':9,'endLine':1008,'endColumn':3},{params:['object','function']}),













_xdResult:__annotator(function(cb,frame,target,
isDefault){return __bodyWrapper(this,arguments,function(){
return (
UIServer._xdNextHandler(__annotator(function(params){
cb && cb(params.result &&
params.result != UIServer._resultToken && ES('JSON','parse',false,
params.result));},{'module':'sdk.UIServer','line':1024,'column':30,'endLine':1028,'endColumn':7}),
frame,target,isDefault) +

'&result=' + encodeURIComponent(UIServer._resultToken));},{params:[[cb,'function','cb'],[frame,'string','frame'],[target,'string','target'],[isDefault,'boolean','isDefault']],returns:'string'});},{'module':'sdk.UIServer','line':1021,'column':11,'endLine':1032,'endColumn':3},{params:['function','string','string','boolean'],returns:'string'}),



xdHandler:__annotator(function(cb,frame,target,
authResponse,method){return __bodyWrapper(this,arguments,function(){
return UIServer._xdNextHandler(
Auth.xdResponseWrapper(cb,authResponse,method),
frame,
target,
true);},{params:[[cb,'function','cb'],[frame,'string','frame'],[target,'string','target'],[authResponse,'?object','authResponse'],[method,'string','method']],returns:'string'});},{'module':'sdk.UIServer','line':1034,'column':11,'endLine':1041,'endColumn':3},{params:['function','string','string','?object','string'],returns:'string'})};




RPC.stub('showDialog');
module.exports = UIServer;},{'module':'sdk.UIServer','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_UIServer'}),null);

__d('sdk.ui',['Assert','sdk.Impressions','Log','sdk.PlatformVersioning','sdk.Runtime','sdk.UIServer','sdk.feature'],__annotator(function $module_sdk_ui(global,require,requireDynamic,requireLazy,module,exports,Assert,Impressions,Log,PlatformVersioning,Runtime,UIServer,feature){if(require.__markCompiled)require.__markCompiled();
































































function ui(params,cb){return __bodyWrapper(this,arguments,function(){
Assert.isObject(params);
Assert.maybeFunction(cb);

if(Runtime.getIsVersioned()){
PlatformVersioning.assertVersionIsSet();
if(params.version){
PlatformVersioning.assertValidVersion(params.version);}else
{
params.version = Runtime.getVersion();}}



params = ES('Object','assign',false,{},params);
if(!params.method){
Log.error('"method" is a required parameter for FB.ui().');
return null;}


if(params.method == 'pay.prompt'){
params.method = 'pay';}


var method=params.method;

if(params.redirect_uri){
Log.warn('When using FB.ui, you should not specify a redirect_uri.');
delete params.redirect_uri;}



if((method == 'permissions.request' || method == 'permissions.oauth') && (
params.display == 'iframe' || params.display == 'dialog')){
params.display = UIServer.checkOauthDisplay(params);}


var enableE2E=feature('e2e_tracking',true);
if(enableE2E){

params.e2e = {};}

var call=UIServer.prepareCall(params,cb || __annotator(function(){},{'module':'sdk.ui','line':112,'column':48,'endLine':112,'endColumn':61}));
if(!call){
return null;}



var displayName=call.params.display;
if(displayName === 'dialog'){

displayName = 'iframe';}else
if(displayName === 'none'){
displayName = 'hidden';}


var displayFn=UIServer[displayName];
if(!displayFn){
Log.error('"display" must be one of "popup", ' +
'"dialog", "iframe", "touch", "async", "hidden", or "none"');
return null;}


if(enableE2E){
call.dialog.subscribe('e2e:end',__annotator(function(events){return __bodyWrapper(this,arguments,function(){
events.method = method;
events.display = displayName;
Log.debug('e2e: %s',ES('JSON','stringify',false,events));

Impressions.log(114,{
payload:events});},{params:[[events,'object','events']]});},{'module':'sdk.ui','line':134,'column':37,'endLine':142,'endColumn':5},{params:['object']}));}



displayFn(call);
return call.dialog;},{params:[[params,'object','params'],[cb,'?function','cb']],returns:'?object'});}__annotator(ui,{'module':'sdk.ui','line':71,'column':0,'endLine':146,'endColumn':1,'name':'ui'},{params:['object','?function'],returns:'?object'});


module.exports = ui;},{'module':'sdk.ui','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_ui'}),null);

__d('legacy:fb.auth',['sdk.Auth','sdk.Cookie','sdk.Event','FB','Log','sdk.Runtime','sdk.SignedRequest','sdk.ui'],__annotator(function $module_legacy_fb_auth(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,Auth,Cookie,Event,FB,Log,Runtime,SignedRequest,ui){if(require.__markCompiled)require.__markCompiled();










FB.provide('',{

getLoginStatus:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return Auth.getLoginStatus.apply(Auth,arguments);},{returns:'?object'});},{'module':'legacy:fb.auth','line':17,'column':18,'endLine':19,'endColumn':3},{returns:'?object'}),


getAuthResponse:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return Auth.getAuthResponse();},{returns:'?object'});},{'module':'legacy:fb.auth','line':21,'column':19,'endLine':23,'endColumn':3},{returns:'?object'}),


getAccessToken:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return Runtime.getAccessToken() || null;},{returns:'?string'});},{'module':'legacy:fb.auth','line':25,'column':18,'endLine':27,'endColumn':3},{returns:'?string'}),


getUserID:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return Runtime.getUserID() || Runtime.getCookieUserID();},{returns:'?string'});},{'module':'legacy:fb.auth','line':29,'column':13,'endLine':31,'endColumn':3},{returns:'?string'}),


login:__annotator(function(cb,opts){return __bodyWrapper(this,arguments,function(){
if(opts && opts.perms && !opts.scope){
opts.scope = opts.perms;
delete opts.perms;
Log.warn('OAuth2 specification states that \'perms\' ' +
'should now be called \'scope\'.  Please update.');}

var canvas=Runtime.isEnvironment(Runtime.ENVIRONMENTS.CANVAS) ||
Runtime.isEnvironment(Runtime.ENVIRONMENTS.PAGETAB);
ui(babelHelpers._extends({
method:'permissions.oauth',

display:canvas?
'async':
'popup',

domain:location.hostname},
opts || {}),

cb);},{params:[[cb,'?function','cb'],[opts,'?object','opts']]});},{'module':'legacy:fb.auth','line':33,'column':9,'endLine':53,'endColumn':3},{params:['?function','?object']}),



logout:__annotator(function(cb){return __bodyWrapper(this,arguments,function(){
ui({method:'auth.logout',display:'hidden'},cb);},{params:[[cb,'?function','cb']]});},{'module':'legacy:fb.auth','line':56,'column':10,'endLine':58,'endColumn':3},{params:['?function']})});



Auth.subscribe('logout',ES(Event.fire,'bind',true,Event,'auth.logout'));
Auth.subscribe('login',ES(Event.fire,'bind',true,Event,'auth.login'));
Auth.subscribe('authresponse.change',ES(Event.fire,'bind',true,Event,
'auth.authResponseChange'));
Auth.subscribe('status.change',ES(Event.fire,'bind',true,Event,'auth.statusChange'));

Event.subscribe('init:post',__annotator(function(options){return __bodyWrapper(this,arguments,function(){
if(options.status){
Auth.getLoginStatus();}

if(Runtime.getClientID()){
if(options.authResponse){
Auth.setAuthResponse(options.authResponse,'connected');}else
if(Runtime.getUseCookie()){


var signedRequest=Cookie.loadSignedRequest(),parsedSignedRequest;
if(signedRequest){
try{
parsedSignedRequest = SignedRequest.parse(signedRequest);}
catch(e) {

Cookie.clearSignedRequestCookie();}

if(parsedSignedRequest && parsedSignedRequest.user_id){
Runtime.setCookieUserID(parsedSignedRequest.user_id);}}


Cookie.loadMeta();}}},{params:[[options,'object','options']]});},{'module':'legacy:fb.auth','line':67,'column':29,'endLine':92,'endColumn':1},{params:['object']}));},{'module':'legacy:fb.auth','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_auth'}),3);

__d('sdk.Canvas.IframeHandling',['DOMWrapper','sdk.RPC'],__annotator(function $module_sdk_Canvas_IframeHandling(global,require,requireDynamic,requireLazy,module,exports,DOMWrapper,RPC){if(require.__markCompiled)require.__markCompiled();




var autoGrowTimer=null;
var autoGrowLastSize;

function getHeight(){
var document=DOMWrapper.getWindow().document;
var body=document.body,
docElement=document.documentElement,
bodyTop=Math.max(body.offsetTop,0),
docTop=Math.max(docElement.offsetTop,0),
bodyScroll=body.scrollHeight + bodyTop,
bodyOffset=body.offsetHeight + bodyTop,
docScroll=docElement.scrollHeight + docTop,
docOffset=docElement.offsetHeight + docTop;

return Math.max(bodyScroll,bodyOffset,docScroll,docOffset);}__annotator(getHeight,{'module':'sdk.Canvas.IframeHandling','line':14,'column':0,'endLine':26,'endColumn':1,'name':'getHeight'});


function setSize(params){return __bodyWrapper(this,arguments,function(){

if(typeof params != 'object'){
params = {};}

var minShrink=0,
minGrow=0;
if(!params.height){
params.height = getHeight();





minShrink = 16;
minGrow = 4;}


if(!params.frame){
params.frame = window.name || 'iframe_canvas';}


if(autoGrowLastSize){
var oldHeight=autoGrowLastSize.height;
var dHeight=params.height - oldHeight;
if(dHeight <= minGrow && dHeight >= -minShrink){
return false;}}


autoGrowLastSize = params;
RPC.remote.setSize(params);
return true;},{params:[[params,'?object','params']],returns:'boolean'});}__annotator(setSize,{'module':'sdk.Canvas.IframeHandling','line':28,'column':0,'endLine':60,'endColumn':1,'name':'setSize'},{params:['?object'],returns:'boolean'});


function setAutoGrow(on,interval){
if(interval === undefined && typeof on === 'number'){
interval = on;
on = true;}


if(on || on === undefined){
if(autoGrowTimer === null){


autoGrowTimer = setInterval(__annotator(function(){
setSize();},{'module':'sdk.Canvas.IframeHandling','line':72,'column':34,'endLine':74,'endColumn':7}),
interval || 100);}

setSize();}else
{
if(autoGrowTimer !== null){
clearInterval(autoGrowTimer);
autoGrowTimer = null;}}}__annotator(setAutoGrow,{'module':'sdk.Canvas.IframeHandling','line':62,'column':0,'endLine':83,'endColumn':1,'name':'setAutoGrow'});




RPC.stub('setSize');

var IframeHandling={
setSize:setSize,
setAutoGrow:setAutoGrow};


module.exports = IframeHandling;},{'module':'sdk.Canvas.IframeHandling','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Canvas_IframeHandling'}),null);

__d('sdk.Canvas.Navigation',['sdk.RPC'],__annotator(function $module_sdk_Canvas_Navigation(global,require,requireDynamic,requireLazy,module,exports,RPC){if(require.__markCompiled)require.__markCompiled();






























function setUrlHandler(callback){return __bodyWrapper(this,arguments,function(){
RPC.local.navigate = __annotator(function(path){return __bodyWrapper(this,arguments,function(){
callback({path:path});},{params:[[path,'string','path']]});},{'module':'sdk.Canvas.Navigation','line':38,'column':23,'endLine':40,'endColumn':3},{params:['string']});

RPC.remote.setNavigationEnabled(true);},{params:[[callback,'function','callback']]});}__annotator(setUrlHandler,{'module':'sdk.Canvas.Navigation','line':37,'column':0,'endLine':42,'endColumn':1,'name':'setUrlHandler'},{params:['function']});



RPC.stub('setNavigationEnabled');

var Navigation={
setUrlHandler:setUrlHandler};


module.exports = Navigation;},{'module':'sdk.Canvas.Navigation','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Canvas_Navigation'}),null);

__d('sdk.Canvas.Plugin',['Log','sdk.RPC','sdk.Runtime','sdk.UA','sdk.api'],__annotator(function $module_sdk_Canvas_Plugin(global,require,requireDynamic,requireLazy,module,exports,Log,RPC,Runtime,UA,api){if(require.__markCompiled)require.__markCompiled();








var flashClassID='CLSID:D27CDB6E-AE6D-11CF-96B8-444553540000';
var unityClassID='CLSID:444785F1-DE89-4295-863A-D46C3A781394';
var devHidePluginCallback=null;









var osx=UA.osx() && UA.osx.getVersionParts();
var unityNeedsToBeHidden=!(osx && osx[0] > 10 && osx[1] > 10 && (
UA.chrome() >= 31 ||
UA.webkit() >= 537.71 ||
UA.firefox() >= 25));








function hideUnityElement(elem){return __bodyWrapper(this,arguments,function(){
elem._hideunity_savedstyle = {};
elem._hideunity_savedstyle.left = elem.style.left;
elem._hideunity_savedstyle.position = elem.style.position;
elem._hideunity_savedstyle.width = elem.style.width;
elem._hideunity_savedstyle.height = elem.style.height;
elem.style.left = '-10000px';
elem.style.position = 'absolute';
elem.style.width = '1px';
elem.style.height = '1px';},{params:[[elem,'HTMLElement','elem']]});}__annotator(hideUnityElement,{'module':'sdk.Canvas.Plugin','line':40,'column':0,'endLine':50,'endColumn':1,'name':'hideUnityElement'},{params:['HTMLElement']});









function showUnityElement(elem){return __bodyWrapper(this,arguments,function(){
if(elem._hideunity_savedstyle){
elem.style.left = elem._hideunity_savedstyle.left;
elem.style.position = elem._hideunity_savedstyle.position;
elem.style.width = elem._hideunity_savedstyle.width;
elem.style.height = elem._hideunity_savedstyle.height;}},{params:[[elem,'HTMLElement','elem']]});}__annotator(showUnityElement,{'module':'sdk.Canvas.Plugin','line':59,'column':0,'endLine':66,'endColumn':1,'name':'showUnityElement'},{params:['HTMLElement']});










function hideFlashElement(elem){return __bodyWrapper(this,arguments,function(){
elem._old_visibility = elem.style.visibility;
elem.style.visibility = 'hidden';},{params:[[elem,'HTMLElement','elem']]});}__annotator(hideFlashElement,{'module':'sdk.Canvas.Plugin','line':75,'column':0,'endLine':78,'endColumn':1,'name':'hideFlashElement'},{params:['HTMLElement']});









function showFlashElement(elem){return __bodyWrapper(this,arguments,function(){
elem.style.visibility = elem._old_visibility || '';
delete elem._old_visibility;},{params:[[elem,'HTMLElement','elem']]});}__annotator(showFlashElement,{'module':'sdk.Canvas.Plugin','line':87,'column':0,'endLine':90,'endColumn':1,'name':'showFlashElement'},{params:['HTMLElement']});


function isHideableFlashElement(elem){return __bodyWrapper(this,arguments,function(){
var type=elem.type?elem.type.toLowerCase():null;
var isHideable=type === 'application/x-shockwave-flash' ||
elem.classid && elem.classid.toUpperCase() == flashClassID;

if(!isHideable){
return false;}




var keepvisibleRegex=/opaque|transparent/i;
if(keepvisibleRegex.test(elem.getAttribute('wmode'))){
return false;}


for(var j=0;j < elem.childNodes.length;j++) {
var node=elem.childNodes[j];
if(/param/i.test(node.nodeName) && /wmode/i.test(node.name) &&
keepvisibleRegex.test(node.value)){
return false;}}


return true;},{params:[[elem,'HTMLElement','elem']]});}__annotator(isHideableFlashElement,{'module':'sdk.Canvas.Plugin','line':92,'column':0,'endLine':116,'endColumn':1,'name':'isHideableFlashElement'},{params:['HTMLElement']});


function isHideableUnityElement(elem){return __bodyWrapper(this,arguments,function(){
var type=elem.type?elem.type.toLowerCase():null;
return type === 'application/vnd.unity' ||
elem.classid && elem.classid.toUpperCase() == unityClassID;},{params:[[elem,'HTMLElement','elem']]});}__annotator(isHideableUnityElement,{'module':'sdk.Canvas.Plugin','line':118,'column':0,'endLine':122,'endColumn':1,'name':'isHideableUnityElement'},{params:['HTMLElement']});







function hidePluginCallback(params){return __bodyWrapper(this,arguments,function(){
var candidates=ES('Array','from',false,
window.document.getElementsByTagName('object'));

candidates = candidates.concat(ES('Array','from',false,
window.document.getElementsByTagName('embed')));


var flashPresent=false;
var unityPresent=false;
ES(candidates,'forEach',true,__annotator(function(elem){return __bodyWrapper(this,arguments,function(){
var isFlashElement=isHideableFlashElement(elem);
var isUnityElement=unityNeedsToBeHidden && isHideableUnityElement(elem);
if(!isFlashElement && !isUnityElement){
return;}


flashPresent = flashPresent || isFlashElement;
unityPresent = unityPresent || isUnityElement;

var visibilityToggleCb=__annotator(function(){
if(params.state === 'opened'){
if(isFlashElement){
hideFlashElement(elem);}else
{
hideUnityElement(elem);}}else

{
if(isFlashElement){
showFlashElement(elem);}else
{
showUnityElement(elem);}}},{'module':'sdk.Canvas.Plugin','line':149,'column':29,'endLine':163,'endColumn':5});




if(devHidePluginCallback){
Log.info('Calling developer specified callback');



var devArgs={state:params.state,elem:elem};
devHidePluginCallback(devArgs);
setTimeout(visibilityToggleCb,200);}else
{
visibilityToggleCb();}},{params:[[elem,'HTMLElement','elem']]});},{'module':'sdk.Canvas.Plugin','line':139,'column':21,'endLine':176,'endColumn':3},{params:['HTMLElement']}));



if(Math.random() <= 1 / 1000){
var opts={
'unity':unityPresent,
'flash':flashPresent};

api(Runtime.getClientID() + '/occludespopups','post',opts);}},{params:[[params,'object','params']]});}__annotator(hidePluginCallback,{'module':'sdk.Canvas.Plugin','line':129,'column':0,'endLine':185,'endColumn':1,'name':'hidePluginCallback'},{params:['object']});



RPC.local.hidePluginObjects = __annotator(function(){
Log.info('hidePluginObjects called');
hidePluginCallback({state:'opened'});},{'module':'sdk.Canvas.Plugin','line':187,'column':30,'endLine':190,'endColumn':1});

RPC.local.showPluginObjects = __annotator(function(){
Log.info('showPluginObjects called');
hidePluginCallback({state:'closed'});},{'module':'sdk.Canvas.Plugin','line':191,'column':30,'endLine':194,'endColumn':1});



RPC.local.showFlashObjects = RPC.local.showPluginObjects;
RPC.local.hideFlashObjects = RPC.local.hidePluginObjects;

function hidePluginElement(){
hideFlashElement();
hideUnityElement();}__annotator(hidePluginElement,{'module':'sdk.Canvas.Plugin','line':200,'column':0,'endLine':203,'endColumn':1,'name':'hidePluginElement'});

function showPluginElement(){
showFlashElement();
showUnityElement();}__annotator(showPluginElement,{'module':'sdk.Canvas.Plugin','line':204,'column':0,'endLine':207,'endColumn':1,'name':'showPluginElement'});


var Plugin={

_setHidePluginCallback:__annotator(function(callback){return __bodyWrapper(this,arguments,function(){
devHidePluginCallback = callback;},{params:[[callback,'?function','callback']]});},{'module':'sdk.Canvas.Plugin','line':211,'column':26,'endLine':213,'endColumn':3},{params:['?function']}),


hidePluginElement:hidePluginElement,
showPluginElement:showPluginElement};


module.exports = Plugin;},{'module':'sdk.Canvas.Plugin','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Canvas_Plugin'}),null);

__d('sdk.Canvas.Tti',['sdk.RPC','sdk.Runtime'],__annotator(function $module_sdk_Canvas_Tti(global,require,requireDynamic,requireLazy,module,exports,RPC,Runtime){if(require.__markCompiled)require.__markCompiled();




function passAppTtiMessage(callback,messageName){return __bodyWrapper(this,arguments,function(){
var params={
appId:Runtime.getClientID(),
time:ES('Date','now',false),
name:messageName};


var args=[params];
if(callback){
args.push(__annotator(function(response){return __bodyWrapper(this,arguments,function(){
callback(response.result);},{params:[[response,'object','response']]});},{'module':'sdk.Canvas.Tti','line':20,'column':14,'endLine':22,'endColumn':5},{params:['object']}));}



RPC.remote.logTtiMessage.apply(null,args);},{params:[[callback,'?function','callback'],[messageName,'string','messageName']]});}__annotator(passAppTtiMessage,{'module':'sdk.Canvas.Tti','line':11,'column':0,'endLine':26,'endColumn':1,'name':'passAppTtiMessage'},{params:['?function','string']});







function startTimer(){
passAppTtiMessage(null,'StartIframeAppTtiTimer');}__annotator(startTimer,{'module':'sdk.Canvas.Tti','line':33,'column':0,'endLine':35,'endColumn':1,'name':'startTimer'});










function stopTimer(callback){return __bodyWrapper(this,arguments,function(){
passAppTtiMessage(callback,'StopIframeAppTtiTimer');},{params:[[callback,'?function','callback']]});}__annotator(stopTimer,{'module':'sdk.Canvas.Tti','line':45,'column':0,'endLine':47,'endColumn':1,'name':'stopTimer'},{params:['?function']});











function setDoneLoading(callback){return __bodyWrapper(this,arguments,function(){
passAppTtiMessage(callback,'RecordIframeAppTti');},{params:[[callback,'?function','callback']]});}__annotator(setDoneLoading,{'module':'sdk.Canvas.Tti','line':58,'column':0,'endLine':60,'endColumn':1,'name':'setDoneLoading'},{params:['?function']});


RPC.stub('logTtiMessage');

var Tti={
setDoneLoading:setDoneLoading,
startTimer:startTimer,
stopTimer:stopTimer};


module.exports = Tti;},{'module':'sdk.Canvas.Tti','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Canvas_Tti'}),null);

__d('legacy:fb.canvas',['Assert','sdk.Canvas.Environment','sdk.Event','FB','sdk.Canvas.IframeHandling','sdk.Canvas.Navigation','sdk.Canvas.Plugin','sdk.RPC','sdk.Runtime','sdk.Canvas.Tti'],__annotator(function $module_legacy_fb_canvas(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,Assert,Environment,Event,FB,IframeHandling,Navigation,Plugin,RPC,Runtime,Tti){if(require.__markCompiled)require.__markCompiled();












FB.provide('Canvas',{

setSize:__annotator(function(params){
Assert.maybeObject(params,'Invalid argument');
return IframeHandling.setSize.apply(null,arguments);},{'module':'legacy:fb.canvas','line':18,'column':11,'endLine':21,'endColumn':3}),

setAutoGrow:__annotator(function(){
return IframeHandling.setAutoGrow.apply(null,arguments);},{'module':'legacy:fb.canvas','line':22,'column':15,'endLine':24,'endColumn':3}),



getPageInfo:__annotator(function(callback){
Assert.isFunction(callback,'Invalid argument');
return Environment.getPageInfo.apply(null,arguments);},{'module':'legacy:fb.canvas','line':27,'column':15,'endLine':30,'endColumn':3}),

scrollTo:__annotator(function(x,y){
Assert.maybeNumber(x,'Invalid argument');
Assert.maybeNumber(y,'Invalid argument');
return Environment.scrollTo.apply(null,arguments);},{'module':'legacy:fb.canvas','line':31,'column':12,'endLine':35,'endColumn':3}),



setDoneLoading:__annotator(function(callback){
Assert.maybeFunction(callback,'Invalid argument');
return Tti.setDoneLoading.apply(null,arguments);},{'module':'legacy:fb.canvas','line':38,'column':18,'endLine':41,'endColumn':3}),

startTimer:__annotator(function(){
return Tti.startTimer.apply(null,arguments);},{'module':'legacy:fb.canvas','line':42,'column':14,'endLine':44,'endColumn':3}),

stopTimer:__annotator(function(callback){
Assert.maybeFunction(callback,'Invalid argument');
return Tti.stopTimer.apply(null,arguments);},{'module':'legacy:fb.canvas','line':45,'column':13,'endLine':48,'endColumn':3}),



getHash:__annotator(function(callback){
Assert.isFunction(callback,'Invalid argument');
return Navigation.getHash.apply(null,arguments);},{'module':'legacy:fb.canvas','line':51,'column':11,'endLine':54,'endColumn':3}),

setHash:__annotator(function(hash){
Assert.isString(hash,'Invalid argument');
return Navigation.setHash.apply(null,arguments);},{'module':'legacy:fb.canvas','line':55,'column':11,'endLine':58,'endColumn':3}),

setUrlHandler:__annotator(function(callback){
Assert.isFunction(callback,'Invalid argument');
return Navigation.setUrlHandler.apply(null,arguments);},{'module':'legacy:fb.canvas','line':59,'column':17,'endLine':62,'endColumn':3})});




RPC.local.fireEvent = ES(Event.fire,'bind',true,Event);

Event.subscribe('init:post',__annotator(function(options){
if(Runtime.isEnvironment(Runtime.ENVIRONMENTS.CANVAS)){
Assert.isTrue(
!options.hideFlashCallback || !options.hidePluginCallback,
'cannot specify deprecated hideFlashCallback and new hidePluginCallback');

Plugin._setHidePluginCallback(
options.hidePluginCallback ||
options.hideFlashCallback);}},{'module':'legacy:fb.canvas','line':68,'column':29,'endLine':79,'endColumn':1}));},{'module':'legacy:fb.canvas','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_canvas'}),3);

__d('sdk.Canvas.Prefetcher',['JSSDKCanvasPrefetcherConfig','sdk.Runtime','sdk.api'],__annotator(function $module_sdk_Canvas_Prefetcher(global,require,requireDynamic,requireLazy,module,exports,CanvasPrefetcherConfig,Runtime,api){if(require.__markCompiled)require.__markCompiled();






var COLLECT={
AUTOMATIC:0,
MANUAL:1};


var sampleRate=CanvasPrefetcherConfig.sampleRate;
var blacklist=CanvasPrefetcherConfig.blacklist;
var collectionMode=COLLECT.AUTOMATIC;
var links=[];

function sample(){

var resourceFieldsByTag={
object:'data',
link:'href',
script:'src'};


if(collectionMode == COLLECT.AUTOMATIC){
ES(ES('Object','keys',false,resourceFieldsByTag),'forEach',true,__annotator(function(tagName){return __bodyWrapper(this,arguments,function(){
var propertyName=resourceFieldsByTag[tagName];
ES(ES('Array','from',false,document.getElementsByTagName(tagName)),'forEach',true,
__annotator(function(tag){return __bodyWrapper(this,arguments,function(){
if(tag[propertyName]){
links.push(tag[propertyName]);}},{params:[[tag,'HTMLElement','tag']]});},{'module':'sdk.Canvas.Prefetcher','line':35,'column':17,'endLine':39,'endColumn':9},{params:['HTMLElement']}));},{params:[[tagName,'string','tagName']]});},{'module':'sdk.Canvas.Prefetcher','line':32,'column':45,'endLine':40,'endColumn':5},{params:['string']}));}





if(links.length === 0){
return;}



api(Runtime.getClientID() + '/staticresources','post',{
urls:ES('JSON','stringify',false,links),
is_https:location.protocol === 'https:'});


links = [];}__annotator(sample,{'module':'sdk.Canvas.Prefetcher','line':23,'column':0,'endLine':54,'endColumn':1,'name':'sample'});


function maybeSample(){
if(!Runtime.isEnvironment(Runtime.ENVIRONMENTS.CANVAS) ||
!Runtime.getClientID() ||
!sampleRate){
return;}


if(Math.random() > 1 / sampleRate ||
blacklist == '*' || ~ES(blacklist,'indexOf',true,Runtime.getClientID())){
return;}



setTimeout(sample,30000);}__annotator(maybeSample,{'module':'sdk.Canvas.Prefetcher','line':56,'column':0,'endLine':70,'endColumn':1,'name':'maybeSample'});















function setCollectionMode(mode){return __bodyWrapper(this,arguments,function(){
collectionMode = mode;},{params:[[mode,'number','mode']]});}__annotator(setCollectionMode,{'module':'sdk.Canvas.Prefetcher','line':85,'column':0,'endLine':87,'endColumn':1,'name':'setCollectionMode'},{params:['number']});






function addStaticResource(url){return __bodyWrapper(this,arguments,function(){
links.push(url);},{params:[[url,'string','url']]});}__annotator(addStaticResource,{'module':'sdk.Canvas.Prefetcher','line':93,'column':0,'endLine':95,'endColumn':1,'name':'addStaticResource'},{params:['string']});


var CanvasPrefetcher={
COLLECT_AUTOMATIC:COLLECT.AUTOMATIC,
COLLECT_MANUAL:COLLECT.MANUAL,

addStaticResource:addStaticResource,
setCollectionMode:setCollectionMode,


_maybeSample:maybeSample};


module.exports = CanvasPrefetcher;},{'module':'sdk.Canvas.Prefetcher','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Canvas_Prefetcher'}),null);

__d('legacy:fb.canvas.prefetcher',['FB','sdk.Canvas.Prefetcher','sdk.Event','sdk.Runtime'],__annotator(function $module_legacy_fb_canvas_prefetcher(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,FB,CanvasPrefetcher,Event,Runtime){if(require.__markCompiled)require.__markCompiled();






FB.provide('Canvas.Prefetcher',CanvasPrefetcher);

Event.subscribe('init:post',__annotator(function(options){
if(Runtime.isEnvironment(Runtime.ENVIRONMENTS.CANVAS)){
CanvasPrefetcher._maybeSample();}},{'module':'legacy:fb.canvas.prefetcher','line':12,'column':29,'endLine':16,'endColumn':1}));},{'module':'legacy:fb.canvas.prefetcher','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_canvas_prefetcher'}),3);

__d('legacy:fb.canvas.presence',['sdk.RPC','sdk.Event'],__annotator(function $module_legacy_fb_canvas_presence(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,RPC,Event){if(require.__markCompiled)require.__markCompiled();




Event.subscribe(Event.SUBSCRIBE,subscriptionAdded);
Event.subscribe(Event.UNSUBSCRIBE,subscriptionRemoved);

RPC.stub('useFriendsOnline');
function subscriptionAdded(name,callbacks){return __bodyWrapper(this,arguments,function(){
if(name != 'canvas.friendsOnlineUpdated'){
return;}

if(callbacks.length === 1){
RPC.remote.useFriendsOnline(true);}},{params:[[name,'string','name'],[callbacks,'array','callbacks']]});}__annotator(subscriptionAdded,{'module':'legacy:fb.canvas.presence','line':13,'column':0,'endLine':20,'endColumn':1,'name':'subscriptionAdded'},{params:['string','array']});



function subscriptionRemoved(name,callbacks){return __bodyWrapper(this,arguments,function(){
if(name != 'canvas.friendsOnlineUpdated'){
return;}

if(callbacks.length === 0){
RPC.remote.useFriendsOnline(false);}},{params:[[name,'string','name'],[callbacks,'array','callbacks']]});}__annotator(subscriptionRemoved,{'module':'legacy:fb.canvas.presence','line':22,'column':0,'endLine':29,'endColumn':1,'name':'subscriptionRemoved'},{params:['string','array']});},{'module':'legacy:fb.canvas.presence','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_canvas_presence'}),3);

__d('legacy:fb.canvas.syncrequests',['sdk.RPC','sdk.Event'],__annotator(function $module_legacy_fb_canvas_syncrequests(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,RPC,Event){if(require.__markCompiled)require.__markCompiled();




RPC.stub('initPendingSyncRequests');
function subscriptionAdded(name,callbacks){return __bodyWrapper(this,arguments,function(){
if(name != 'canvas.syncRequestUpdated'){
return;}

RPC.remote.initPendingSyncRequests();
Event.unsubscribe(Event.SUBSCRIBE,subscriptionAdded);},{params:[[name,'string','name'],[callbacks,'array','callbacks']]});}__annotator(subscriptionAdded,{'module':'legacy:fb.canvas.syncrequests','line':10,'column':0,'endLine':16,'endColumn':1,'name':'subscriptionAdded'},{params:['string','array']});


Event.subscribe(Event.SUBSCRIBE,subscriptionAdded);},{'module':'legacy:fb.canvas.syncrequests','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_canvas_syncrequests'}),3);

__d('legacy:fb.event',['FB','sdk.Event','sdk.Runtime','sdk.Scribe','sdk.feature'],__annotator(function $module_legacy_fb_event(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,FB,Event,Runtime,Scribe,feature){if(require.__markCompiled)require.__markCompiled();








var eventsToLog=[];
var logScheduleId=null;
var logTimeout=feature('event_subscriptions_log',false);

FB.provide('Event',{
subscribe:__annotator(function(name,cb){
if(logTimeout){
eventsToLog.push(name);



if(!logScheduleId){
logScheduleId = setTimeout(__annotator(function(){

Scribe.log('jssdk_error',{
appId:Runtime.getClientID(),
error:'EVENT_SUBSCRIPTIONS_LOG',
extra:{
line:0,
name:'EVENT_SUBSCRIPTIONS_LOG',
script:'N/A',
stack:'N/A',
message:eventsToLog.sort().join(',')}});



eventsToLog.length = 0;
logScheduleId = null;},{'module':'legacy:fb.event','line':24,'column':35,'endLine':41,'endColumn':9}),

logTimeout);}}


return Event.subscribe(name,cb);},{'module':'legacy:fb.event','line':17,'column':11,'endLine':45,'endColumn':3}),


unsubscribe:ES(Event.unsubscribe,'bind',true,Event)});},{'module':'legacy:fb.event','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_event'}),3);

__d('legacy:fb.frictionless',['FB','sdk.Frictionless'],__annotator(function $module_legacy_fb_frictionless(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,FB,Frictionless){if(require.__markCompiled)require.__markCompiled();



FB.provide('Frictionless',Frictionless);},{'module':'legacy:fb.frictionless','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_frictionless'}),3);

__d('sdk.init',['sdk.Cookie','sdk.ErrorHandling','sdk.Event','sdk.Impressions','Log','ManagedError','sdk.PlatformVersioning','QueryString','sdk.Runtime','sdk.URI','sdk.feature'],__annotator(function $module_sdk_init(global,require,requireDynamic,requireLazy,module,exports,Cookie,ErrorHandling,Event,Impressions,Log,ManagedError,PlatformVersioning,QueryString,Runtime,URI,feature){if(require.__markCompiled)require.__markCompiled();




















function parseAppId(appId){return __bodyWrapper(this,arguments,function(){
var looksValid=
typeof appId == 'number' && appId > 0 ||
typeof appId == 'string' && /^[0-9a-f]{21,}$|^[0-9]{1,21}$/.test(appId);
if(looksValid){
return appId.toString();}

Log.warn('Invalid App Id: Must be a number or numeric string representing ' +
'the application id.');
return null;},{params:[[appId,'string|number','appId']],returns:'?string'});}__annotator(parseAppId,{'module':'sdk.init','line':27,'column':0,'endLine':37,'endColumn':1,'name':'parseAppId'},{params:['string|number'],returns:'?string'});


















function init(options){return __bodyWrapper(this,arguments,function(){
if(Runtime.getInitialized()){
Log.warn(
'FB.init has already been called - this could indicate a problem');}



if(Runtime.getIsVersioned()){

if(Object.prototype.toString.call(options) !== '[object Object]'){
throw new ManagedError('Invalid argument');}


if(options.authResponse){
Log.warn('Setting authResponse is not supported');}


if(!options.version){

options.version = new URI(location.href).getQueryData().sdk_version;}


PlatformVersioning.assertValidVersion(options.version);
Runtime.setVersion(options.version);}else
{

if(/number|string/.test(typeof options)){
Log.warn('FB.init called with invalid parameters');
options = {apiKey:options};}


options = ES('Object','assign',false,{
status:true},
options || {});}



var appId=parseAppId(options.appId || options.apiKey);
if(appId !== null){
Runtime.setClientID(appId);}


if('scope' in options){
Runtime.setScope(options.scope);}


if(options.cookie){
Runtime.setUseCookie(true);
if(typeof options.cookie === 'string'){
Cookie.setDomain(options.cookie);}}



if(options.kidDirectedSite){
Runtime.setKidDirectedSite(true);}


Runtime.setInitialized(true);


if(feature('js_sdk_impression_on_load',true)){

Impressions.log(115,{});}


Event.fire('init:post',options);},{params:[[options,'object|number|string','options']]});}__annotator(init,{'module':'sdk.init','line':55,'column':0,'endLine':121,'endColumn':1,'name':'init'},{params:['object|number|string']});





setTimeout(__annotator(function(){


var pattern=/(connect\.facebook\.net|\.facebook\.com\/assets.php).*?#(.*)/;
ES(ES('Array','from',false,fb_fif_window.document.getElementsByTagName('script')),'forEach',true,
__annotator(function(script){
if(script.src){
var match=pattern.exec(script.src);
if(match){
var opts=QueryString.decode(match[2]);
for(var key in opts) {
if(opts.hasOwnProperty(key)){
var val=opts[key];
if(val == '0'){
opts[key] = 0;}}}




init(opts);}}},{'module':'sdk.init','line':131,'column':13,'endLine':148,'endColumn':5}));






if(window.fbAsyncInit && !window.fbAsyncInit.hasRun){
window.fbAsyncInit.hasRun = true;
ErrorHandling.unguard(window.fbAsyncInit)();}},{'module':'sdk.init','line':126,'column':11,'endLine':156,'endColumn':1}),

0);

module.exports = init;},{'module':'sdk.init','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_init'}),null);

__d('legacy:fb.init',['FB','sdk.init'],__annotator(function $module_legacy_fb_init(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,FB,init){if(require.__markCompiled)require.__markCompiled();




FB.provide('',{
init:init});},{'module':'legacy:fb.init','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_init'}),3);

__d('legacy:fb.ui',['FB','sdk.ui'],__annotator(function $module_legacy_fb_ui(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,FB,ui){if(require.__markCompiled)require.__markCompiled();




FB.provide('',{
ui:ui});},{'module':'legacy:fb.ui','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_ui'}),3);

__d('legacy:fb.versioned-sdk',['sdk.Runtime'],__annotator(function $module_legacy_fb_versioned_sdk(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,Runtime){if(require.__markCompiled)require.__markCompiled();


Runtime.setIsVersioned(true);},{'module':'legacy:fb.versioned-sdk','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_versioned_sdk'}),3);

__d("runOnce",[],__annotator(function $module_runOnce(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function runOnce(func){
var run,ret;
return __annotator(function(){
if(!run){
run = true;
ret = func();}

return ret;},{"module":"runOnce","line":9,"column":9,"endLine":15,"endColumn":3});}__annotator(runOnce,{"module":"runOnce","line":7,"column":0,"endLine":16,"endColumn":1,"name":"runOnce"});



module.exports = runOnce;},{"module":"runOnce","line":0,"column":0,"endLine":0,"endColumn":0,"name":"$module_runOnce"}),null);

__d('XFBML',['Assert','sdk.DOM','Log','ObservableMixin','sdk.UA','runOnce'],__annotator(function $module_XFBML(global,require,requireDynamic,requireLazy,module,exports,Assert,DOM,Log,ObservableMixin,UA,runOnce){if(require.__markCompiled)require.__markCompiled();










var xfbml={};
var html5={};

var parseCount=0;

var XFBML=new ObservableMixin();

function propStr(object,property){return __bodyWrapper(this,arguments,function(){
return ES(object[property] + '','trim',true);},{params:[[property,'string','property']],returns:'string'});}__annotator(propStr,{'module':'XFBML','line':29,'column':0,'endLine':31,'endColumn':1,'name':'propStr'},{params:['string'],returns:'string'});


function nodeNameIE(element){return __bodyWrapper(this,arguments,function(){


return element.scopeName?
element.scopeName + ':' + element.nodeName:
'';},{params:[[element,'HTMLElement','element']],returns:'string'});}__annotator(nodeNameIE,{'module':'XFBML','line':33,'column':0,'endLine':39,'endColumn':1,'name':'nodeNameIE'},{params:['HTMLElement'],returns:'string'});


function xfbmlInfo(element){return __bodyWrapper(this,arguments,function(){
return xfbml[propStr(element,'nodeName').toLowerCase()] ||
xfbml[nodeNameIE(element).toLowerCase()];},{params:[[element,'HTMLElement','element']],returns:'?object'});}__annotator(xfbmlInfo,{'module':'XFBML','line':41,'column':0,'endLine':44,'endColumn':1,'name':'xfbmlInfo'},{params:['HTMLElement'],returns:'?object'});


function html5Info(element){return __bodyWrapper(this,arguments,function(){
var classNames=ES(propStr(element,'className').split(/\s+/),'filter',true,__annotator(
function(className){return html5.hasOwnProperty(className);},{'module':'XFBML','line':48,'column':4,'endLine':48,'endColumn':67}));

if(classNames.length === 0){
return undefined;}















if(
element.getAttribute('fb-xfbml-state') ||
!element.childNodes ||
element.childNodes.length === 0 ||
element.childNodes.length === 1 &&
element.childNodes[0].nodeType === 3 ||
element.children.length === 1 &&
propStr(element.children[0],'className') === 'fb-xfbml-parse-ignore')
{
return html5[classNames[0]];}},{params:[[element,'HTMLElement','element']],returns:'?object'});}__annotator(html5Info,{'module':'XFBML','line':46,'column':0,'endLine':78,'endColumn':1,'name':'html5Info'},{params:['HTMLElement'],returns:'?object'});



function attr(element){return __bodyWrapper(this,arguments,function(){
var attrs={};
ES(ES('Array','from',false,element.attributes),'forEach',true,__annotator(function(at){
attrs[propStr(at,'name')] = propStr(at,'value');},{'module':'XFBML','line':82,'column':41,'endLine':84,'endColumn':3}));

return attrs;},{params:[[element,'HTMLElement','element']],returns:'object'});}__annotator(attr,{'module':'XFBML','line':80,'column':0,'endLine':86,'endColumn':1,'name':'attr'},{params:['HTMLElement'],returns:'object'});


function convertSyntax(
element,ns,ln){return __bodyWrapper(this,arguments,function(){
var replacement=document.createElement('div');
DOM.addCss(element,ns + '-' + ln);
ES(ES('Array','from',false,element.childNodes),'forEach',true,__annotator(function(child){
replacement.appendChild(child);},{'module':'XFBML','line':92,'column':41,'endLine':94,'endColumn':3}));

ES(ES('Array','from',false,element.attributes),'forEach',true,__annotator(function(attribute){
replacement.setAttribute(attribute.name,attribute.value);},{'module':'XFBML','line':95,'column':41,'endLine':97,'endColumn':3}));

element.parentNode.replaceChild(replacement,element);
return replacement;},{params:[[element,'HTMLElement','element'],[ns,'string','ns'],[ln,'string','ln']],returns:'HTMLElement'});}__annotator(convertSyntax,{'module':'XFBML','line':88,'column':0,'endLine':100,'endColumn':1,'name':'convertSyntax'},{params:['HTMLElement','string','string'],returns:'HTMLElement'});


function parse(dom,callback,reparse){return __bodyWrapper(this,arguments,function(){
Assert.isTrue(
dom && dom.nodeType && dom.nodeType === 1 && !!dom.getElementsByTagName,
'Invalid DOM node passed to FB.XFBML.parse()');
Assert.isFunction(callback,'Invalid callback passed to FB.XFBML.parse()');

var pc=++parseCount;
Log.info('XFBML Parsing Start %s',pc);





var count=1;
var tags=0;
var onrender=__annotator(function(){
count--;
if(count === 0){
Log.info('XFBML Parsing Finish %s, %s tags found',pc,tags);
callback();
XFBML.inform('render',pc,tags);}

Assert.isTrue(count >= 0,'onrender() has been called too many times');},{'module':'XFBML','line':117,'column':17,'endLine':125,'endColumn':3});


ES(ES('Array','from',false,dom.getElementsByTagName('*')),'forEach',true,__annotator(function(element){
if(!reparse && element.getAttribute('fb-xfbml-state')){

return;}

if(element.nodeType !== 1){

return;}


var info=xfbmlInfo(element) || html5Info(element);
if(!info){
return;}


if(UA.ie() < 9 && element.scopeName){


element = convertSyntax(element,info.xmlns,info.localName);}


count++;
tags++;
var renderer=
new info.ctor(element,info.xmlns,info.localName,attr(element));



renderer.subscribe('render',runOnce(__annotator(function(){




element.setAttribute('fb-xfbml-state','rendered');
onrender();},{'module':'XFBML','line':155,'column':41,'endLine':162,'endColumn':5})));


var render=__annotator(function(){


if(element.getAttribute('fb-xfbml-state') == 'parsed'){


XFBML.subscribe('render.queue',render);}else
{
element.setAttribute('fb-xfbml-state','parsed');
renderer.process();}},{'module':'XFBML','line':164,'column':17,'endLine':175,'endColumn':5});



render();},{'module':'XFBML','line':127,'column':52,'endLine':178,'endColumn':3}));


XFBML.inform('parse',pc,tags);

var timeout=30000;
setTimeout(__annotator(function(){
if(count > 0){
Log.warn('%s tags failed to render in %s ms',count,timeout);}},{'module':'XFBML','line':183,'column':13,'endLine':187,'endColumn':3}),

timeout);

onrender();},{params:[[dom,'HTMLElement','dom'],[callback,'function','callback'],[reparse,'boolean','reparse']]});}__annotator(parse,{'module':'XFBML','line':102,'column':0,'endLine':190,'endColumn':1,'name':'parse'},{params:['HTMLElement','function','boolean']});


XFBML.subscribe('render',__annotator(function(){
var q=XFBML.getSubscribers('render.queue');
XFBML.clearSubscribers('render.queue');
ES(q,'forEach',true,__annotator(function(r){r();},{'module':'XFBML','line':195,'column':12,'endLine':195,'endColumn':32}));},{'module':'XFBML','line':192,'column':26,'endLine':198,'endColumn':1}));




ES('Object','assign',false,XFBML,{

registerTag:__annotator(function(info){return __bodyWrapper(this,arguments,function(){
var fqn=info.xmlns + ':' + info.localName;
Assert.isUndefined(xfbml[fqn],fqn + ' already registered');

xfbml[fqn] = info;



html5[info.xmlns + '-' + info.localName] = info;},{params:[[info,'object','info']]});},{'module':'XFBML','line':202,'column':15,'endLine':211,'endColumn':3},{params:['object']}),


parse:__annotator(function(dom,cb){return __bodyWrapper(this,arguments,function(){
parse(dom || document.body,cb || __annotator(function(){},{'module':'XFBML','line':214,'column':38,'endLine':214,'endColumn':46}),true);},{params:[[dom,'?HTMLElement','dom'],[cb,'?function','cb']]});},{'module':'XFBML','line':213,'column':9,'endLine':215,'endColumn':3},{params:['?HTMLElement','?function']}),


parseNew:__annotator(function(){
parse(document.body,__annotator(function(){},{'module':'XFBML','line':218,'column':25,'endLine':218,'endColumn':33}),false);},{'module':'XFBML','line':217,'column':12,'endLine':219,'endColumn':3})});



module.exports = XFBML;},{'module':'XFBML','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_XFBML'}),null);

__d('PluginPipe',['sdk.Content','sdk.feature','guid','insertIframe','Miny','ObservableMixin','JSSDKPluginPipeConfig','sdk.Runtime','sdk.UA','UrlMap','XFBML'],__annotator(function $module_PluginPipe(global,require,requireDynamic,requireLazy,module,exports,Content,feature,guid,insertIframe,Miny,ObservableMixin,PluginPipeConfig,Runtime,UA,UrlMap,XFBML){if(require.__markCompiled)require.__markCompiled();












var PluginPipe=new ObservableMixin();

var threshold=PluginPipeConfig.threshold;
var queued=[];

function isEnabled(){return __bodyWrapper(this,arguments,function(){
return !!(feature('plugin_pipe',false) &&
Runtime.getSecure() !== undefined && (
UA.chrome() || UA.firefox()) &&
PluginPipeConfig.enabledApps[Runtime.getClientID()]);},{returns:'boolean'});}__annotator(isEnabled,{'module':'PluginPipe','line':25,'column':0,'endLine':30,'endColumn':1,'name':'isEnabled'},{returns:'boolean'});


function insertPlugins(){
var q=queued;
queued = [];

if(q.length <= threshold){
ES(q,'forEach',true,__annotator(function(plugin){return __bodyWrapper(this,arguments,function(){
insertIframe(plugin.config);},{params:[[plugin,'object','plugin']]});},{'module':'PluginPipe','line':37,'column':14,'endLine':39,'endColumn':5},{params:['object']}));

return;}


var count=q.length + 1;
function onrender(){
count--;
if(count === 0){
insertPipe(q);}}__annotator(onrender,{'module':'PluginPipe','line':44,'column':2,'endLine':49,'endColumn':3,'name':'onrender'});



ES(q,'forEach',true,__annotator(function(plugin){return __bodyWrapper(this,arguments,function(){
var config={};
for(var key in plugin.config) {
config[key] = plugin.config[key];}

config.url = UrlMap.resolve('www',Runtime.getSecure()) +
'/plugins/plugin_pipe_shell.php';
config.onload = onrender;
insertIframe(config);},{params:[[plugin,'object','plugin']]});},{'module':'PluginPipe','line':51,'column':12,'endLine':60,'endColumn':3},{params:['object']}));


onrender();}__annotator(insertPlugins,{'module':'PluginPipe','line':32,'column':0,'endLine':63,'endColumn':1,'name':'insertPlugins'});


XFBML.subscribe('parse',insertPlugins);

function insertPipe(plugins){return __bodyWrapper(this,arguments,function(){
var root=document.createElement('span');
Content.appendHidden(root);

var params={};
ES(plugins,'forEach',true,__annotator(function(plugin){return __bodyWrapper(this,arguments,function(){
params[plugin.config.name] = {
plugin:plugin.tag,
params:plugin.params};},{params:[[plugin,'object','plugin']]});},{'module':'PluginPipe','line':72,'column':18,'endLine':77,'endColumn':3},{params:['object']}));



var raw=ES('JSON','stringify',false,params);
var miny=Miny.encode(raw);

ES(plugins,'forEach',true,__annotator(function(plugin){return __bodyWrapper(this,arguments,function(){
var frame=document.getElementsByName(plugin.config.name)[0];
frame.onload = plugin.config.onload;},{params:[[plugin,'object','plugin']]});},{'module':'PluginPipe','line':82,'column':18,'endLine':85,'endColumn':3},{params:['object']}));


var url=UrlMap.resolve('www',Runtime.getSecure()) + '/plugins/pipe.php';
var name=guid();

insertIframe({
url:'about:blank',
root:root,
name:name,
className:'fb_hidden fb_invisible',
onload:__annotator(function(){
Content.submitToTarget({
url:url,
target:name,
params:{
plugins:miny.length < raw.length?miny:raw}});},{'module':'PluginPipe','line':95,'column':12,'endLine':102,'endColumn':5})});},{params:[[plugins,'array<object>','plugins']]});}__annotator(insertPipe,{'module':'PluginPipe','line':67,'column':0,'endLine':104,'endColumn':1,'name':'insertPipe'},{params:['array<object>']});





ES('Object','assign',false,PluginPipe,{
add:__annotator(function(plugin){return __bodyWrapper(this,arguments,function(){
var enabled=isEnabled();
enabled && queued.push({
config:plugin._config,
tag:plugin._tag,
params:plugin._params});

return enabled;},{params:[[plugin,'object','plugin']],returns:'boolean'});},{'module':'PluginPipe','line':107,'column':7,'endLine':115,'endColumn':3},{params:['object'],returns:'boolean'})});



module.exports = PluginPipe;},{'module':'PluginPipe','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_PluginPipe'}),null);

__d('IframePlugin',['sdk.Auth','sdk.DOM','sdk.Event','Log','ObservableMixin','sdk.PlatformVersioning','PluginPipe','QueryString','sdk.Runtime','Type','sdk.UA','sdk.URI','UrlMap','sdk.XD','sdk.createIframe','sdk.feature','guid','resolveURI'],__annotator(function $module_IframePlugin(global,require,requireDynamic,requireLazy,module,exports,Auth,DOM,Event,Log,ObservableMixin,PlatformVersioning,PluginPipe,QueryString,Runtime,Type,UA,URI,UrlMap,XD,createIframe,feature,guid,resolveURI){if(require.__markCompiled)require.__markCompiled();





















var baseParams={
skin:'string',
font:'string',
width:'px',
height:'px',
ref:'string',
color_scheme:'string'};


function resize(elem,width,height){return __bodyWrapper(this,arguments,function(){
if(width || width === 0){
if(width === '100%'){
elem.style.width = '100%';}else
{
elem.style.width = width + 'px';}}



if(height || height === 0){
elem.style.height = height + 'px';}},{params:[[elem,'HTMLElement','elem'],[width,'?number','width'],[height,'?number','height']]});}__annotator(resize,{'module':'IframePlugin','line':43,'column':0,'endLine':55,'endColumn':1,'name':'resize'},{params:['HTMLElement','?number','?number']});



function resizeBubbler(pluginID){return __bodyWrapper(this,arguments,function(){
return __annotator(function(msg){
var message={width:msg.width,height:msg.height,pluginID:pluginID};
Event.fire('xfbml.resize',message);},{'module':'IframePlugin','line':58,'column':9,'endLine':61,'endColumn':3});},{params:[[pluginID,'?string','pluginID']],returns:'function'});}__annotator(resizeBubbler,{'module':'IframePlugin','line':57,'column':0,'endLine':62,'endColumn':1,'name':'resizeBubbler'},{params:['?string'],returns:'function'});



var types={

string:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
return value;},{params:[[value,'?string','value']],returns:'?string'});},{'module':'IframePlugin','line':66,'column':10,'endLine':68,'endColumn':3},{params:['?string'],returns:'?string'}),

bool:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
return value?/^(?:true|1|yes|on)$/i.test(value):undefined;},{params:[[value,'?string','value']],returns:'?boolean'});},{'module':'IframePlugin','line':69,'column':8,'endLine':71,'endColumn':3},{params:['?string'],returns:'?boolean'}),

url:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
return resolveURI(value);},{params:[[value,'?string','value']],returns:'?string'});},{'module':'IframePlugin','line':72,'column':7,'endLine':74,'endColumn':3},{params:['?string'],returns:'?string'}),

url_maybe:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
return value?resolveURI(value):value;},{params:[[value,'?string','value']],returns:'?string'});},{'module':'IframePlugin','line':75,'column':13,'endLine':77,'endColumn':3},{params:['?string'],returns:'?string'}),

hostname:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
return value || window.location.hostname;},{params:[[value,'?string','value']],returns:'?string'});},{'module':'IframePlugin','line':78,'column':12,'endLine':80,'endColumn':3},{params:['?string'],returns:'?string'}),

px:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
return (/^(\d+)(?:px)?$/.test(value)?parseInt(RegExp.$1,10):undefined);},{params:[[value,'?string','value']],returns:'?number'});},{'module':'IframePlugin','line':81,'column':6,'endLine':83,'endColumn':3},{params:['?string'],returns:'?number'}),

text:__annotator(function(value){return __bodyWrapper(this,arguments,function(){
return value;},{params:[[value,'?string','value']],returns:'?string'});},{'module':'IframePlugin','line':84,'column':8,'endLine':86,'endColumn':3},{params:['?string'],returns:'?string'})};



function getVal(attr,key){return __bodyWrapper(this,arguments,function(){
var val=
attr[key] ||
attr[key.replace(/_/g,'-')] ||
attr[key.replace(/_/g,'')] ||
attr['data-' + key] ||
attr['data-' + key.replace(/_/g,'-')] ||
attr['data-' + key.replace(/_/g,'')] ||
undefined;
return val;},{params:[[attr,'object','attr'],[key,'string','key']]});}__annotator(getVal,{'module':'IframePlugin','line':89,'column':0,'endLine':99,'endColumn':1,'name':'getVal'},{params:['object','string']});


function validate(defn,elem,attr,
params){return __bodyWrapper(this,arguments,function(){
ES(ES('Object','keys',false,defn),'forEach',true,__annotator(function(key){
if(defn[key] == 'text' && !attr[key]){
attr[key] = elem.textContent || elem.innerText || '';
elem.setAttribute(key,attr[key]);}

params[key] = types[defn[key]](getVal(attr,key));},{'module':'IframePlugin','line':103,'column':28,'endLine':109,'endColumn':3}));},{params:[[defn,'object','defn'],[elem,'HTMLElement','elem'],[attr,'object','attr'],[params,'object','params']]});}__annotator(validate,{'module':'IframePlugin','line':101,'column':0,'endLine':110,'endColumn':1,'name':'validate'},{params:['object','HTMLElement','object','object']});





function parse(dim){
if(dim === '100%'){
return '100%';}


return dim || dim === '0' || dim === 0?parseInt(dim,10):undefined;}__annotator(parse,{'module':'IframePlugin','line':114,'column':0,'endLine':120,'endColumn':1,'name':'parse'});


function collapseIframe(iframe){
if(iframe){
resize(iframe,0,0);}}__annotator(collapseIframe,{'module':'IframePlugin','line':122,'column':0,'endLine':126,'endColumn':1,'name':'collapseIframe'});




var IframePlugin=Type.extend({
constructor:__annotator(function(
elem,
ns,
tag,
attr){return __bodyWrapper(this,arguments,function()
{
this.parent();
tag = tag.replace(/-/g,'_');

var pluginId=getVal(attr,'plugin_id');
this.subscribe('xd.resize',resizeBubbler(pluginId));
this.subscribe('xd.resize.flow',resizeBubbler(pluginId));

this.subscribe('xd.resize.flow',ES(__annotator(function(message){
ES('Object','assign',false,this._iframeOptions.root.style,{
verticalAlign:'bottom',
overflow:''});

resize(
this._iframeOptions.root,
parse(message.width),
parse(message.height));

this.updateLift();
clearTimeout(this._timeoutID);},{'module':'IframePlugin','line':143,'column':37,'endLine':155,'endColumn':5}),'bind',true,this));


this.subscribe('xd.resize',ES(__annotator(function(message){
ES('Object','assign',false,this._iframeOptions.root.style,{
verticalAlign:'bottom',
overflow:''});

resize(
this._iframeOptions.root,
parse(message.width),
parse(message.height));

resize(this._iframe,parse(message.width),parse(message.height));
this._isIframeResized = true;
this.updateLift();
clearTimeout(this._timeoutID);},{'module':'IframePlugin','line':157,'column':32,'endLine':171,'endColumn':5}),'bind',true,this));


this.subscribe('xd.resize.iframe',ES(__annotator(function(message){
if(
message.reposition === 'true' &&
feature('reposition_iframe',false))
{
this.reposition(parse(message.width));}


resize(this._iframe,parse(message.width),parse(message.height));
this._isIframeResized = true;
this.updateLift();
clearTimeout(this._timeoutID);},{'module':'IframePlugin','line':173,'column':39,'endLine':185,'endColumn':5}),'bind',true,this));


this.subscribe('xd.sdk_event',__annotator(function(message){return __bodyWrapper(this,arguments,function(){
var data=ES('JSON','parse',false,message.data);
data.pluginID = pluginId;
Event.fire(message.event,data,elem);},{params:[[message,'object','message']]});},{'module':'IframePlugin','line':187,'column':35,'endLine':191,'endColumn':5},{params:['object']}));


var secure=Runtime.getSecure() || window.location.protocol == 'https:';

var url=UrlMap.resolve('www',secure) + '/plugins/' + tag + '.php?';
var params={};
validate(this.getParams(),elem,attr,params);
validate(baseParams,elem,attr,params);

ES('Object','assign',false,params,{
app_id:Runtime.getClientID(),
locale:Runtime.getLocale(),
sdk:'joey',
kid_directed_site:Runtime.getKidDirectedSite(),
channel:XD.handler(ES(__annotator(
function(msg){return this.inform('xd.' + msg.type,msg);},{'module':'IframePlugin','line':206,'column':8,'endLine':206,'endColumn':49}),'bind',true,this),
'parent.parent',
true)});



params.container_width = elem.offsetWidth;

DOM.addCss(elem,'fb_iframe_widget');
var name=guid();
this.subscribe('xd.verify',__annotator(function(msg){return __bodyWrapper(this,arguments,function(){
XD.sendToFacebook(
name,{method:'xd/verify',params:ES('JSON','stringify',false,msg.token)});},{params:[[msg,'object','msg']]});},{'module':'IframePlugin','line':216,'column':32,'endLine':219,'endColumn':5},{params:['object']}));


this.subscribe(
'xd.refreshLoginStatus',ES(Auth.getLoginStatus,'bind',true,
Auth,ES(this.inform,'bind',true,this,'login.status'),true));

var flow=document.createElement('span');



ES('Object','assign',false,flow.style,{
verticalAlign:'top',
width:'0px',
height:'0px',
overflow:'hidden'});


this._element = elem;
this._ns = ns;
this._tag = tag;
this._params = params;
this._config = this.getConfig();
this._iframeOptions = {
root:flow,
url:url + QueryString.encode(params),
name:name,





width:this._config.mobile_fullsize && UA.mobile()?
void 0:
params.width || 1000,
height:params.height || 1000,
style:{
border:'none',
visibility:'hidden'},

title:this._ns + ':' + this._tag + ' Facebook Social Plugin',
onload:ES(__annotator(function(){return this.inform('render');},{'module':'IframePlugin','line':259,'column':14,'endLine':259,'endColumn':41}),'bind',true,this),
onerror:ES(__annotator(function(){return collapseIframe(this._iframe);},{'module':'IframePlugin','line':260,'column':15,'endLine':260,'endColumn':49}),'bind',true,this)};


if(this.isFluid()){
DOM.addCss(this._element,'fb_iframe_widget_fluid_desktop');
if(!params.width && this._config.full_width){
this._element.style.width = '100%';
this._iframeOptions.root.style.width = '100%';
this._iframeOptions.style.width = '100%';
this._params.container_width = this._element.offsetWidth;
this._iframeOptions.url = url + QueryString.encode(this._params);}}},{params:[[elem,'HTMLElement','elem'],[ns,'string','ns'],[tag,'string','tag'],[attr,'object','attr']]});},{'module':'IframePlugin','line':130,'column':13,'endLine':274,'endColumn':3},{params:['HTMLElement','string','string','object']}),





process:__annotator(function(){
if(Runtime.getIsVersioned()){
PlatformVersioning.assertVersionIsSet();
var uri=new URI(this._iframeOptions.url);
this._iframeOptions.url =
uri.setPath('/' + Runtime.getVersion() + uri.getPath()).toString();}



var params=ES('Object','assign',false,{},this._params);
delete params.channel;
var query=QueryString.encode(params);
if(this._element.getAttribute('fb-iframe-plugin-query') == query){
Log.info('Skipping render: %s:%s %s',this._ns,this._tag,query);
this.inform('render');
return;}

this._element.setAttribute('fb-iframe-plugin-query',query);

this.subscribe('render',ES(__annotator(function(){
this._iframe.style.visibility = 'visible';




if(!this._isIframeResized){
collapseIframe(this._iframe);}},{'module':'IframePlugin','line':295,'column':29,'endLine':304,'endColumn':5}),'bind',true,this));



while(this._element.firstChild) {
this._element.removeChild(this._element.firstChild);}

this._element.appendChild(this._iframeOptions.root);
var timeout=UA.mobile()?120:45;
this._timeoutID = setTimeout(ES(__annotator(function(){
collapseIframe(this._iframe);
Log.warn(
'%s:%s failed to resize in %ss',
this._ns,
this._tag,
timeout);},{'module':'IframePlugin','line':311,'column':33,'endLine':319,'endColumn':5}),'bind',true,this),

timeout * 1000);






if(!PluginPipe.add(this)){
this._iframe = createIframe(this._iframeOptions);}

if(UA.mobile()){
DOM.addCss(this._element,'fb_iframe_widget_fluid');

if(!this._iframeOptions.width){
ES('Object','assign',false,this._element.style,{
display:'block',
width:'100%',
height:'auto'});


ES('Object','assign',false,this._iframeOptions.root.style,{
width:'100%',
height:'auto'});


var iframeStyle={
height:'auto',
position:'static',
width:'100%'};


if(UA.iphone() || UA.ipad()){












ES('Object','assign',false,iframeStyle,{
width:'220px',
'min-width':'100%'});}



ES('Object','assign',false,this._iframe.style,iframeStyle);}}},{'module':'IframePlugin','line':276,'column':9,'endLine':372,'endColumn':3}),







getConfig:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return {};},{returns:'object'});},{'module':'IframePlugin','line':377,'column':11,'endLine':379,'endColumn':3},{returns:'object'}),


isFluid:__annotator(function(){
var config=this.getConfig();
return config.fluid;},{'module':'IframePlugin','line':381,'column':9,'endLine':384,'endColumn':3}),


reposition:__annotator(function(newWidth){
var leftPosition=DOM.getPosition(this._iframe).x;
var screenWidth=DOM.getViewportInfo().width;

var oldWidth=parseInt(DOM.getStyle(this._iframe,'width'),10);

var params={};
if(
leftPosition + newWidth > screenWidth &&
leftPosition > newWidth)
{
this._iframe.style.left =
parseInt(DOM.getStyle(this._iframe,'width'),10) - newWidth + 'px';

this._isRepositioned = true;
params.type = 'reposition';}else

if(this._isRepositioned && oldWidth - newWidth !== 0){

this._iframe.style.left = '0px';
this._isRepositioned = false;
params.type = 'restore';}else

{

return;}


XD.sendToFacebook(
this._iframe.name,
{
method:'xd/reposition',
params:ES('JSON','stringify',false,params)});},{'module':'IframePlugin','line':386,'column':12,'endLine':421,'endColumn':3}),




updateLift:__annotator(function(){
var same=
this._iframe.style.width === this._iframeOptions.root.style.width &&
this._iframe.style.height === this._iframeOptions.root.style.height;
DOM[same?'removeCss':'addCss'](this._iframe,'fb_iframe_widget_lift');},{'module':'IframePlugin','line':423,'column':12,'endLine':428,'endColumn':3})},

ObservableMixin);

IframePlugin.getVal = getVal;

IframePlugin.withParams = __annotator(function(
params,
config){return __bodyWrapper(this,arguments,function()
{
return IframePlugin.extend({
getParams:__annotator(function(){
return params;},{'module':'IframePlugin','line':438,'column':13,'endLine':440,'endColumn':5}),


getConfig:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return config?config:{};},{returns:'object'});},{'module':'IframePlugin','line':442,'column':13,'endLine':444,'endColumn':5},{returns:'object'})});},{params:[[params,'object','params'],[config,'?object','config']],returns:'function'});},{'module':'IframePlugin','line':433,'column':26,'endLine':446,'endColumn':1},{params:['object','?object'],returns:'function'});




module.exports = IframePlugin;},{'module':'IframePlugin','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_IframePlugin'}),null);

__d('PluginConfig',['sdk.feature'],__annotator(function $module_PluginConfig(global,require,requireDynamic,requireLazy,module,exports,feature){if(require.__markCompiled)require.__markCompiled();



var PluginConfig={
messengerpreconfirmation:{
mobile_fullsize:true},

messengeraccountconfirmation:{
mobile_fullsize:true},

messengerbusinesslink:{
mobile_fullsize:true},

messengertoggle:{
mobile_fullsize:true},

messengermessageus:{
mobile_fullsize:true},

post:{
fluid:feature('fluid_embed',false),
mobile_fullsize:true}};



module.exports = PluginConfig;},{'module':'PluginConfig','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_PluginConfig'}),null);

__d('PluginTags',[],__annotator(function $module_PluginTags(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var PluginTags={
composer:{
action_type:'string',
action_properties:'string'},


create_event_button:{},


follow:{
href:'url',
layout:'string',
show_faces:'bool'},


like:{
href:'url',
layout:'string',
show_faces:'bool',
share:'bool',
action:'string',

send:'bool'},


like_box:{
href:'string',
show_faces:'bool',
header:'bool',
stream:'bool',
force_wall:'bool',
show_border:'bool',

id:'string',
connections:'string',
profile_id:'string',
name:'string'},


page:{
href:'string',
hide_cta:'bool',
hide_cover:'bool',
small_header:'bool',
adapt_container_width:'bool',
show_facepile:'bool',
show_posts:'bool',
tabs:'string'},


messengerpreconfirmation:{
messenger_app_id:'string'},


messengeraccountconfirmation:{
messenger_app_id:'string',
state:'string'},


messengerbusinesslink:{
messenger_app_id:'string',
state:'string'},


messengertoggle:{
messenger_app_id:'string',
token:'string'},


messengermessageus:{
messenger_app_id:'string',
color:'string',
size:'string'},


page_events:{
href:'url'},


post:{
href:'url',
show_border:'bool'},


profile_pic:{
uid:'string',
linked:'bool',
href:'string',
size:'string',
facebook_logo:'bool'},


send:{
href:'url'},


send_to_mobile:{
max_rows:'string',
show_faces:'bool',
size:'string'}};




var aliases={
subscribe:'follow',
fan:'like_box',
likebox:'like_box'};


ES(ES('Object','keys',false,aliases),'forEach',true,__annotator(function(key){
PluginTags[key] = PluginTags[aliases[key]];},{'module':'PluginTags','line':142,'column':29,'endLine':144,'endColumn':1}));


module.exports = PluginTags;},{'module':'PluginTags','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_PluginTags'}),null);

__d('sdk.Arbiter',[],__annotator(function $module_sdk_Arbiter(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var Arbiter={
BEHAVIOR_EVENT:'e',
BEHAVIOR_PERSISTENT:'p',
BEHAVIOR_STATE:'s'};

module.exports = Arbiter;},{'module':'sdk.Arbiter','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Arbiter'}),null);

__d('sdk.XFBML.Element',['sdk.DOM','Type','ObservableMixin'],__annotator(function $module_sdk_XFBML_Element(global,require,requireDynamic,requireLazy,module,exports,DOM,Type,ObservableMixin){if(require.__markCompiled)require.__markCompiled();









var Element=Type.extend({






constructor:__annotator(function(dom){return __bodyWrapper(this,arguments,function(){
this.parent();
this.dom = dom;},{params:[[dom,'HTMLElement','dom']]});},{'module':'sdk.XFBML.Element','line':23,'column':15,'endLine':26,'endColumn':3},{params:['HTMLElement']}),


fire:__annotator(function(){
this.inform.apply(this,arguments);},{'module':'sdk.XFBML.Element','line':28,'column':8,'endLine':30,'endColumn':3}),













getAttribute:__annotator(function(name,defaultValue,
transform){return __bodyWrapper(this,arguments,function(){
var value=DOM.getAttr(this.dom,name);
return value?
transform?
transform(value):
value:
defaultValue;},{params:[[name,'string','name'],[transform,'?function','transform']]});},{'module':'sdk.XFBML.Element','line':43,'column':16,'endLine':51,'endColumn':3},{params:['string','?function']}),








_getBoolAttribute:__annotator(function(name,defaultValue){return __bodyWrapper(this,arguments,function()
{
var value=DOM.getBoolAttr(this.dom,name);
return value === null?
defaultValue:
value;},{params:[[name,'string','name'],[defaultValue,'?boolean','defaultValue']],returns:'?boolean'});},{'module':'sdk.XFBML.Element','line':59,'column':21,'endLine':65,'endColumn':3},{params:['string','?boolean'],returns:'?boolean'}),








_getPxAttribute:__annotator(function(name,defaultValue){return __bodyWrapper(this,arguments,function()
{
return this.getAttribute(name,defaultValue,__annotator(function(s){return __bodyWrapper(this,arguments,function(){
var value=parseInt(s,10);
return isNaN(value)?defaultValue:value;},{params:[[s,'string','s']]});},{'module':'sdk.XFBML.Element','line':75,'column':49,'endLine':78,'endColumn':5},{params:['string']}));},{params:[[name,'string','name'],[defaultValue,'?number','defaultValue']],returns:'?number'});},{'module':'sdk.XFBML.Element','line':73,'column':19,'endLine':79,'endColumn':3},{params:['string','?number'],returns:'?number'}),









_getLengthAttribute:__annotator(function(name,defaultValue){return __bodyWrapper(this,arguments,function(){
return this.getAttribute(name,defaultValue,__annotator(function(s){return __bodyWrapper(this,arguments,function(){
if(s === '100%'){
return s;}

var value=parseInt(s,10);
return isNaN(value)?defaultValue:value;},{params:[[s,'string','s']]});},{'module':'sdk.XFBML.Element','line':88,'column':49,'endLine':94,'endColumn':5},{params:['string']}));},{params:[[name,'string','name'],[defaultValue,'?number','defaultValue']]});},{'module':'sdk.XFBML.Element','line':87,'column':23,'endLine':95,'endColumn':3},{params:['string','?number']}),












_getAttributeFromList:__annotator(function(name,defaultValue,
allowed){return __bodyWrapper(this,arguments,function(){
return this.getAttribute(name,defaultValue,__annotator(function(s){return __bodyWrapper(this,arguments,function()
{
s = s.toLowerCase();
return ES(allowed,'indexOf',true,s) > -1?
s:
defaultValue;},{params:[[s,'string','s']],returns:'string'});},{'module':'sdk.XFBML.Element','line':108,'column':49,'endLine':114,'endColumn':5},{params:['string'],returns:'string'}));},{params:[[name,'string','name'],[defaultValue,'string','defaultValue'],[allowed,'array<string>','allowed']],returns:'string'});},{'module':'sdk.XFBML.Element','line':106,'column':25,'endLine':115,'endColumn':3},{params:['string','string','array<string>'],returns:'string'}),








isValid:__annotator(function(){return __bodyWrapper(this,arguments,function(){
for(var dom=this.dom;dom;dom = dom.parentNode) {
if(dom == document.body){
return true;}}},{returns:'?boolean'});},{'module':'sdk.XFBML.Element','line':122,'column':11,'endLine':128,'endColumn':3},{returns:'?boolean'}),








clear:__annotator(function(){
DOM.html(this.dom,'');},{'module':'sdk.XFBML.Element','line':134,'column':9,'endLine':136,'endColumn':3})},


ObservableMixin);

module.exports = Element;},{'module':'sdk.XFBML.Element','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_Element'}),null);

__d('sdk.XFBML.IframeWidget',['sdk.Arbiter','sdk.Auth','sdk.Content','sdk.DOM','sdk.Event','sdk.XFBML.Element','guid','insertIframe','QueryString','sdk.Runtime','sdk.ui','UrlMap','sdk.XD'],__annotator(function $module_sdk_XFBML_IframeWidget(global,require,requireDynamic,requireLazy,module,exports,Arbiter,Auth,Content,DOM,Event,Element,guid,insertIframe,QueryString,Runtime,ui,UrlMap,XD){if(require.__markCompiled)require.__markCompiled();


















var IframeWidget=Element.extend({






_iframeName:null,





_showLoader:true,






_refreshOnAuthChange:false,






_allowReProcess:false,






_fetchPreCachedLoader:false,








_visibleAfter:'load',






_widgetPipeEnabled:false,





_borderReset:false,






_repositioned:false,

















getUrlBits:__annotator(function(){return __bodyWrapper(this,arguments,function(){
throw new Error('Inheriting class needs to implement getUrlBits().');},{returns:'object'});},{'module':'sdk.XFBML.IframeWidget','line':107,'column':14,'endLine':109,'endColumn':3},{returns:'object'}),
















setupAndValidate:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return true;},{returns:'boolean'});},{'module':'sdk.XFBML.IframeWidget','line':125,'column':20,'endLine':127,'endColumn':3},{returns:'boolean'}),






oneTimeSetup:__annotator(function(){},{'module':'sdk.XFBML.IframeWidget','line':133,'column':16,'endLine':133,'endColumn':29}),









getSize:__annotator(function(){return __bodyWrapper(this,arguments,function(){},{returns:'object'});},{'module':'sdk.XFBML.IframeWidget','line':143,'column':11,'endLine':143,'endColumn':35},{returns:'object'}),












getIframeName:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return this._iframeName;},{returns:'?string'});},{'module':'sdk.XFBML.IframeWidget','line':156,'column':17,'endLine':158,'endColumn':3},{returns:'?string'}),






getIframeTitle:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return 'Facebook Social Plugin';},{returns:'?string'});},{'module':'sdk.XFBML.IframeWidget','line':164,'column':18,'endLine':166,'endColumn':3},{returns:'?string'}),











getChannelUrl:__annotator(function(){return __bodyWrapper(this,arguments,function(){
if(!this._channelUrl){


var self=this;
this._channelUrl = XD.handler(__annotator(function(message){
self.fire('xd.' + message.type,message);},{'module':'sdk.XFBML.IframeWidget','line':182,'column':36,'endLine':184,'endColumn':7}),
'parent.parent',true);}

return this._channelUrl;},{returns:'string'});},{'module':'sdk.XFBML.IframeWidget','line':177,'column':17,'endLine':187,'endColumn':3},{returns:'string'}),







getIframeNode:__annotator(function(){return __bodyWrapper(this,arguments,function(){


return this.dom.getElementsByTagName('iframe')[0];},{returns:'?HTMLElement'});},{'module':'sdk.XFBML.IframeWidget','line':194,'column':17,'endLine':198,'endColumn':3},{returns:'?HTMLElement'}),





arbiterInform:__annotator(function(event,message,
behavior){return __bodyWrapper(this,arguments,function(){
XD.sendToFacebook(
this.getIframeName(),{
method:event,
params:ES('JSON','stringify',false,message || {}),
behavior:behavior || Arbiter.BEHAVIOR_PERSISTENT});},{params:[[event,'string','event'],[message,'?object','message'],[behavior,'?string','behavior']]});},{'module':'sdk.XFBML.IframeWidget','line':203,'column':17,'endLine':211,'endColumn':3},{params:['string','?object','?string']}),



_arbiterInform:__annotator(function(event,message,
behavior){return __bodyWrapper(this,arguments,function(){
var relation='parent.frames["' + this.getIframeNode().name + '"]';
XD.inform(event,message,relation,behavior);},{params:[[event,'string','event'],[message,'object','message'],[behavior,'?string','behavior']]});},{'module':'sdk.XFBML.IframeWidget','line':213,'column':18,'endLine':217,'endColumn':3},{params:['string','object','?string']}),






getDefaultWebDomain:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return UrlMap.resolve('www');},{returns:'string'});},{'module':'sdk.XFBML.IframeWidget','line':223,'column':23,'endLine':225,'endColumn':3},{returns:'string'}),












process:__annotator(function(force){return __bodyWrapper(this,arguments,function(){

if(this._done){
if(!this._allowReProcess && !force){
return;}

this.clear();}else
{
this._oneTimeSetup();}

this._done = true;

this._iframeName = this.getIframeName() || this._iframeName || guid();
if(!this.setupAndValidate()){

this.fire('render');
return;}



if(this._showLoader){
this._addLoader();}



DOM.addCss(this.dom,'fb_iframe_widget');
if(this._visibleAfter != 'immediate'){
DOM.addCss(this.dom,'fb_hide_iframes');}else
{
this.subscribe('iframe.onload',ES(this.fire,'bind',true,this,'render'));}



var size=this.getSize() || {};
var url=this.getFullyQualifiedURL();

if(size.width == '100%'){
DOM.addCss(this.dom,'fb_iframe_widget_fluid');}


this.clear();
insertIframe({
url:url,
root:this.dom.appendChild(document.createElement('span')),
name:this._iframeName,
title:this.getIframeTitle(),
className:Runtime.getRtl()?'fb_rtl':'fb_ltr',
height:size.height,
width:size.width,
onload:ES(this.fire,'bind',true,this,'iframe.onload')});


this._resizeFlow(size);

this.loaded = false;
this.subscribe('iframe.onload',ES(__annotator(function(){
this.loaded = true;


if(!this._isResizeHandled){
DOM.addCss(this.dom,'fb_hide_iframes');}},{'module':'sdk.XFBML.IframeWidget','line':292,'column':36,'endLine':299,'endColumn':5}),'bind',true,this));},{params:[[force,'?boolean','force']]});},{'module':'sdk.XFBML.IframeWidget','line':237,'column':11,'endLine':300,'endColumn':3},{params:['?boolean']}),












generateWidgetPipeIframeName:__annotator(function(){return __bodyWrapper(this,arguments,function(){
widgetPipeIframeCount++;
return 'fb_iframe_' + widgetPipeIframeCount;},{returns:'string'});},{'module':'sdk.XFBML.IframeWidget','line':310,'column':32,'endLine':313,'endColumn':3},{returns:'string'}),












getFullyQualifiedURL:__annotator(function(){return __bodyWrapper(this,arguments,function(){



var url=this._getURL();
url += '?' + QueryString.encode(this._getQS());

if(url.length > 2000){

url = 'about:blank';
var onload=ES(__annotator(function(){
this._postRequest();
this.unsubscribe('iframe.onload',onload);},{'module':'sdk.XFBML.IframeWidget','line':335,'column':19,'endLine':338,'endColumn':7}),'bind',true,
this);
this.subscribe('iframe.onload',onload);}


return url;},{returns:'string'});},{'module':'sdk.XFBML.IframeWidget','line':325,'column':24,'endLine':343,'endColumn':3},{returns:'string'}),













_getWidgetPipeShell:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return UrlMap.resolve('www') + '/common/widget_pipe_shell.php';},{returns:'string'});},{'module':'sdk.XFBML.IframeWidget','line':356,'column':23,'endLine':358,'endColumn':3},{returns:'string'}),





_oneTimeSetup:__annotator(function(){


this.subscribe('xd.resize',ES(this._handleResizeMsg,'bind',true,this));
this.subscribe('xd.resize',ES(this._bubbleResizeEvent,'bind',true,this));

this.subscribe('xd.resize.iframe',ES(this._resizeIframe,'bind',true,this));
this.subscribe('xd.resize.flow',ES(this._resizeFlow,'bind',true,this));
this.subscribe('xd.resize.flow',ES(this._bubbleResizeEvent,'bind',true,this));

this.subscribe('xd.refreshLoginStatus',__annotator(function(){
Auth.getLoginStatus(__annotator(function(){},{'module':'sdk.XFBML.IframeWidget','line':374,'column':26,'endLine':374,'endColumn':38}),true);},{'module':'sdk.XFBML.IframeWidget','line':373,'column':44,'endLine':375,'endColumn':5}));

this.subscribe('xd.logout',__annotator(function(){
ui({method:'auth.logout',display:'hidden'},__annotator(function(){},{'module':'sdk.XFBML.IframeWidget','line':377,'column':55,'endLine':377,'endColumn':68}));},{'module':'sdk.XFBML.IframeWidget','line':376,'column':32,'endLine':378,'endColumn':5}));



if(this._refreshOnAuthChange){
this._setupAuthRefresh();}



if(this._visibleAfter == 'load'){
this.subscribe('iframe.onload',ES(this._makeVisible,'bind',true,this));}


this.subscribe(
'xd.verify',ES(__annotator(function(message){
this.arbiterInform('xd/verify',message.token);},{'module':'sdk.XFBML.IframeWidget','line':391,'column':19,'endLine':393,'endColumn':9}),'bind',true,
this));


this.oneTimeSetup();},{'module':'sdk.XFBML.IframeWidget','line':363,'column':17,'endLine':397,'endColumn':3}),





_makeVisible:__annotator(function(){
this._removeLoader();
DOM.removeCss(this.dom,'fb_hide_iframes');
this.fire('render');},{'module':'sdk.XFBML.IframeWidget','line':402,'column':16,'endLine':406,'endColumn':3}),











_setupAuthRefresh:__annotator(function(){
Auth.getLoginStatus(ES(__annotator(function(response){return __bodyWrapper(this,arguments,function(){
var lastStatus=response.status;
Event.subscribe('auth.statusChange',ES(__annotator(function(response){return __bodyWrapper(this,arguments,function(){
if(!this.isValid()){
return;}


if(lastStatus == 'unknown' || response.status == 'unknown'){
this.process(true);}

lastStatus = response.status;},{params:[[response,'object','response']]});},{'module':'sdk.XFBML.IframeWidget','line':420,'column':43,'endLine':429,'endColumn':7},{params:['object']}),'bind',true,
this));},{params:[[response,'object','response']]});},{'module':'sdk.XFBML.IframeWidget','line':418,'column':24,'endLine':430,'endColumn':5},{params:['object']}),'bind',true,
this));},{'module':'sdk.XFBML.IframeWidget','line':417,'column':21,'endLine':431,'endColumn':3}),





_handleResizeMsg:__annotator(function(message){return __bodyWrapper(this,arguments,function(){
if(!this.isValid()){
return;}

this._resizeIframe(message);
this._resizeFlow(message);

if(!this._borderReset){
this.getIframeNode().style.border = 'none';
this._borderReset = true;}


this._isResizeHandled = true;
this._makeVisible();},{params:[[message,'object','message']]});},{'module':'sdk.XFBML.IframeWidget','line':436,'column':20,'endLine':450,'endColumn':3},{params:['object']}),





_bubbleResizeEvent:__annotator(function(message){return __bodyWrapper(this,arguments,function(){
var filtered_message={
height:message.height,
width:message.width,
pluginID:this.getAttribute('plugin-id')};


Event.fire('xfbml.resize',filtered_message);},{params:[[message,'object','message']]});},{'module':'sdk.XFBML.IframeWidget','line':455,'column':22,'endLine':463,'endColumn':3},{params:['object']}),


_resizeIframe:__annotator(function(message){return __bodyWrapper(this,arguments,function(){
var iframe=this.getIframeNode();
if(message.reposition === "true"){
this._repositionIframe(message);}

message.height && (iframe.style.height = message.height + 'px');
message.width && (iframe.style.width = message.width + 'px');
this._updateIframeZIndex();},{params:[[message,'object','message']]});},{'module':'sdk.XFBML.IframeWidget','line':465,'column':17,'endLine':473,'endColumn':3},{params:['object']}),


_resizeFlow:__annotator(function(message){return __bodyWrapper(this,arguments,function(){
var span=this.dom.getElementsByTagName('span')[0];
message.height && (span.style.height = message.height + 'px');
message.width && (span.style.width = message.width + 'px');
this._updateIframeZIndex();},{params:[[message,'object','message']]});},{'module':'sdk.XFBML.IframeWidget','line':475,'column':15,'endLine':480,'endColumn':3},{params:['object']}),


_updateIframeZIndex:__annotator(function(){
var span=this.dom.getElementsByTagName('span')[0];
var iframe=this.getIframeNode();
var identical=iframe.style.height === span.style.height &&
iframe.style.width === span.style.width;
var method=identical?'removeCss':'addCss';
DOM[method](iframe,'fb_iframe_widget_lift');},{'module':'sdk.XFBML.IframeWidget','line':482,'column':23,'endLine':489,'endColumn':3}),


_repositionIframe:__annotator(function(message){return __bodyWrapper(this,arguments,function(){
var iframe=this.getIframeNode();
var iframe_width=parseInt(DOM.getStyle(iframe,'width'),10);
var left=DOM.getPosition(iframe).x;
var screen_width=DOM.getViewportInfo().width;
var comment_width=parseInt(message.width,10);
if(left + comment_width > screen_width &&
left > comment_width){
iframe.style.left = iframe_width - comment_width + 'px';
this.arbiterInform('xd/reposition',{type:'horizontal'});
this._repositioned = true;}else
if(this._repositioned){
iframe.style.left = '0px';
this.arbiterInform('xd/reposition',{type:'restore'});
this._repositioned = false;}},{params:[[message,'object','message']]});},{'module':'sdk.XFBML.IframeWidget','line':491,'column':21,'endLine':507,'endColumn':3},{params:['object']}),






_addLoader:__annotator(function(){
if(!this._loaderDiv){
DOM.addCss(this.dom,'fb_iframe_widget_loader');
this._loaderDiv = document.createElement('div');
this._loaderDiv.className = 'FB_Loader';
this.dom.appendChild(this._loaderDiv);}},{'module':'sdk.XFBML.IframeWidget','line':512,'column':14,'endLine':519,'endColumn':3}),






_removeLoader:__annotator(function(){
if(this._loaderDiv){
DOM.removeCss(this.dom,'fb_iframe_widget_loader');
if(this._loaderDiv.parentNode){
this._loaderDiv.parentNode.removeChild(this._loaderDiv);}

this._loaderDiv = null;}},{'module':'sdk.XFBML.IframeWidget','line':524,'column':17,'endLine':532,'endColumn':3}),









_getQS:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return ES('Object','assign',false,{
api_key:Runtime.getClientID(),
locale:Runtime.getLocale(),
sdk:'joey',
kid_directed_site:Runtime.getKidDirectedSite(),
ref:this.getAttribute('ref')},
this.getUrlBits().params);},{returns:'object'});},{'module':'sdk.XFBML.IframeWidget','line':540,'column':10,'endLine':548,'endColumn':3},{returns:'object'}),







_getURL:__annotator(function(){return __bodyWrapper(this,arguments,function(){
var
domain=this.getDefaultWebDomain(),
static_path='';

return domain + '/plugins/' + static_path +
this.getUrlBits().name + '.php';},{returns:'string'});},{'module':'sdk.XFBML.IframeWidget','line':555,'column':11,'endLine':562,'endColumn':3},{returns:'string'}),





_postRequest:__annotator(function(){
Content.submitToTarget({
url:this._getURL(),
target:this.getIframeNode().name,
params:this._getQS()});},{'module':'sdk.XFBML.IframeWidget','line':567,'column':16,'endLine':573,'endColumn':3})});




var widgetPipeIframeCount=0;
var allWidgetPipeIframes={};

function groupWidgetPipeDescriptions(){return __bodyWrapper(this,arguments,function(){
var widgetPipeDescriptions={};
for(var key in allWidgetPipeIframes) {
var controller=allWidgetPipeIframes[key];

widgetPipeDescriptions[key] = {
widget:controller.getUrlBits().name,
params:controller._getQS()};}



return widgetPipeDescriptions;},{returns:'object'});}__annotator(groupWidgetPipeDescriptions,{'module':'sdk.XFBML.IframeWidget','line':579,'column':0,'endLine':591,'endColumn':1,'name':'groupWidgetPipeDescriptions'},{returns:'object'});










































module.exports = IframeWidget;},{'module':'sdk.XFBML.IframeWidget','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_IframeWidget'}),null);

__d('sdk.XFBML.Comments',['sdk.Event','sdk.XFBML.IframeWidget','QueryString','sdk.Runtime','JSSDKConfig','sdk.UA','UrlMap'],__annotator(function $module_sdk_XFBML_Comments(global,require,requireDynamic,requireLazy,module,exports,Event,IframeWidget,QueryString,Runtime,SDKConfig,UA,UrlMap){if(require.__markCompiled)require.__markCompiled();









var Comments=IframeWidget.extend({
_visibleAfter:'immediate',




_refreshOnAuthChange:true,




setupAndValidate:__annotator(function(){return __bodyWrapper(this,arguments,function(){

var attr={
channel_url:this.getChannelUrl(),
colorscheme:this.getAttribute('colorscheme'),
skin:this.getAttribute('skin'),
numposts:this.getAttribute('num-posts',10),
width:this._getLengthAttribute('width'),
href:this.getAttribute('href'),
permalink:this.getAttribute('permalink'),
publish_feed:this.getAttribute('publish_feed'),
order_by:this.getAttribute('order_by'),
mobile:this._getBoolAttribute('mobile'),
version:this.getAttribute('version')};


if(!attr.width && !attr.permalink){
attr.width = 550;}


if(SDKConfig.initSitevars.enableMobileComments &&
UA.mobile() &&
attr.mobile !== false){
attr.mobile = true;
delete attr.width;}

if(!attr.skin){
attr.skin = attr.colorscheme;}



if(!attr.href){
attr.migrated = this.getAttribute('migrated');
attr.xid = this.getAttribute('xid');
attr.title = this.getAttribute('title',document.title);
attr.url = this.getAttribute('url',document.URL);
attr.quiet = this.getAttribute('quiet');
attr.reverse = this.getAttribute('reverse');
attr.simple = this.getAttribute('simple');
attr.css = this.getAttribute('css');
attr.notify = this.getAttribute('notify');


if(!attr.xid){



var index=ES(document.URL,'indexOf',true,'#');
if(index > 0){
attr.xid = encodeURIComponent(document.URL.substring(0,index));}else
{
attr.xid = encodeURIComponent(document.URL);}}



if(attr.migrated){
attr.href =
UrlMap.resolve('www') + '/plugins/comments_v1.php?' +
'app_id=' + Runtime.getClientID() +
'&xid=' + encodeURIComponent(attr.xid) +
'&url=' + encodeURIComponent(attr.url);}}else

{

var fb_comment_id=this.getAttribute('fb_comment_id');
if(!fb_comment_id){
fb_comment_id =
QueryString.decode(
document.URL.substring(
ES(document.URL,'indexOf',true,'?') + 1)).fb_comment_id;
if(fb_comment_id && ES(fb_comment_id,'indexOf',true,'#') > 0){

fb_comment_id =
fb_comment_id.substring(0,ES(
fb_comment_id,'indexOf',true,'#'));}}



if(fb_comment_id){
attr.fb_comment_id = fb_comment_id;
this.subscribe('render',ES(
__annotator(function(){



if(!window.location.hash){
window.location.hash = this.getIframeNode().id;}},{'module':'sdk.XFBML.Comments','line':110,'column':10,'endLine':117,'endColumn':11}),'bind',true,

this));}}



if(!attr.version){
attr.version = Runtime.getVersion();}


this._attr = attr;
return true;},{returns:'boolean'});},{'module':'sdk.XFBML.Comments','line':29,'column':20,'endLine':127,'endColumn':3},{returns:'boolean'}),





oneTimeSetup:__annotator(function(){
this.subscribe('xd.sdk_event',__annotator(function(message){return __bodyWrapper(this,arguments,function(){
Event.fire(message.event,ES('JSON','parse',false,message.data));},{params:[[message,'object','message']]});},{'module':'sdk.XFBML.Comments','line':133,'column':35,'endLine':135,'endColumn':5},{params:['object']}));},{'module':'sdk.XFBML.Comments','line':132,'column':16,'endLine':137,'endColumn':3}),









getSize:__annotator(function(){return __bodyWrapper(this,arguments,function(){
if(!this._attr.permalink){
return {
width:this._attr.mobile?'100%':this._attr.width,


height:100};}},{returns:'?object'});},{'module':'sdk.XFBML.Comments','line':144,'column':11,'endLine':153,'endColumn':3},{returns:'?object'}),









getUrlBits:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return {name:'comments',params:this._attr};},{returns:'object'});},{'module':'sdk.XFBML.Comments','line':160,'column':14,'endLine':162,'endColumn':3},{returns:'object'}),










getDefaultWebDomain:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return UrlMap.resolve('www',true);},{returns:'string'});},{'module':'sdk.XFBML.Comments','line':172,'column':23,'endLine':174,'endColumn':3},{returns:'string'})});



module.exports = Comments;},{'module':'sdk.XFBML.Comments','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_Comments'}),null);

__d('sdk.XFBML.CommentsCount',['ApiClient','sdk.DOM','sdk.XFBML.Element','sprintf'],__annotator(function $module_sdk_XFBML_CommentsCount(global,require,requireDynamic,requireLazy,module,exports,ApiClient,DOM,Element,sprintf){if(require.__markCompiled)require.__markCompiled();






var CommentsCount=Element.extend({

process:__annotator(function(){
DOM.addCss(this.dom,'fb_comments_count_zero');

var href=this.getAttribute('href',window.location.href);

ApiClient.scheduleBatchCall(
'/v2.1/' + encodeURIComponent(href),
{fields:'share'},ES(__annotator(
function(value){
var c=value.share && value.share.comment_count || 0;
DOM.html(
this.dom,
sprintf('<span class="fb_comments_count">%s</span>',c));


if(c > 0){
DOM.removeCss(this.dom,'fb_comments_count_zero');}


this.fire('render');},{'module':'sdk.XFBML.CommentsCount','line':23,'column':6,'endLine':35,'endColumn':7}),'bind',true,this));},{'module':'sdk.XFBML.CommentsCount','line':15,'column':9,'endLine':37,'endColumn':3})});






module.exports = CommentsCount;},{'module':'sdk.XFBML.CommentsCount','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_CommentsCount'}),null);

__d('safeEval',[],__annotator(function $module_safeEval(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

function safeEval(source,args){return __bodyWrapper(this,arguments,function(){
if(source === null || typeof source === 'undefined'){
return;}

if(typeof source !== 'string'){
return source;}



if(/^\w+$/.test(source) && typeof window[source] === 'function'){
return window[source].apply(null,args || []);}



return Function('return eval("' + source.replace(/"/g,'\\"') + '");').
apply(null,args || []);},{params:[[args,'?array','args']]});}__annotator(safeEval,{'module':'safeEval','line':11,'column':0,'endLine':27,'endColumn':1,'name':'safeEval'},{params:['?array']});


module.exports = safeEval;},{'module':'safeEval','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_safeEval'}),null);

__d('sdk.Helper',['sdk.ErrorHandling','sdk.Event','UrlMap','safeEval','sprintf'],__annotator(function $module_sdk_Helper(global,require,requireDynamic,requireLazy,module,exports,ErrorHandling,Event,UrlMap,safeEval,sprintf){if(require.__markCompiled)require.__markCompiled();








var Helper={









isUser:__annotator(function(id){return __bodyWrapper(this,arguments,function(){
return id < 2200000000 ||
id >= 100000000000000 &&
id <= 100099999989999 ||
id >= 89000000000000 &&
id <= 89999999999999 ||
id >= 60000010000000 &&
id <= 60000019999999;},{returns:'boolean'});},{'module':'sdk.Helper','line':25,'column':10,'endLine':33,'endColumn':3},{returns:'boolean'}),








upperCaseFirstChar:__annotator(function(s){return __bodyWrapper(this,arguments,function(){
if(s.length > 0){
return s.substr(0,1).toUpperCase() + s.substr(1);}else

{
return s;}},{params:[[s,'string','s']],returns:'string'});},{'module':'sdk.Helper','line':41,'column':22,'endLine':48,'endColumn':3},{params:['string'],returns:'string'}),











getProfileLink:__annotator(function(
userInfo,
html,
href){return __bodyWrapper(this,arguments,function()
{
if(!href && userInfo){
href = sprintf(
'%s/profile.php?id=%s',
UrlMap.resolve('www'),
userInfo.uid || userInfo.id);}


if(href){
html = sprintf('<a class="fb_link" href="%s">%s</a>',href,html);}

return html;},{params:[[userInfo,'?object','userInfo'],[html,'string','html'],[href,'?string','href']],returns:'string'});},{'module':'sdk.Helper','line':58,'column':18,'endLine':74,'endColumn':3},{params:['?object','string','?string'],returns:'string'}),










invokeHandler:__annotator(function(handler,scope,args){return __bodyWrapper(this,arguments,function(){
if(handler){
if(typeof handler === 'string'){
ErrorHandling.unguard(safeEval)(handler,args);}else
if(handler.apply){
ErrorHandling.unguard(handler).apply(scope,args || []);}}},{params:[[scope,'?object','scope'],[args,'?array','args']]});},{'module':'sdk.Helper','line':84,'column':17,'endLine':92,'endColumn':3},{params:['?object','?array']}),












fireEvent:__annotator(function(eventName,eventSource){return __bodyWrapper(this,arguments,function(){
var href=eventSource._attr.href;
eventSource.fire(eventName,href);
Event.fire(eventName,href,eventSource);},{params:[[eventName,'string','eventName'],[eventSource,'object','eventSource']]});},{'module':'sdk.Helper','line':102,'column':13,'endLine':106,'endColumn':3},{params:['string','object']}),







executeFunctionByName:__annotator(function(functionName){return __bodyWrapper(this,arguments,function(){
var args=Array.prototype.slice.call(arguments,1);
var namespaces=functionName.split(".");
var func=namespaces.pop();
var context=window;
for(var i=0;i < namespaces.length;i++) {
context = context[namespaces[i]];}

return context[func].apply(this,args);},{params:[[functionName,'string','functionName']]});},{'module':'sdk.Helper','line':113,'column':25,'endLine':122,'endColumn':3},{params:['string']})};




module.exports = Helper;},{'module':'sdk.Helper','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_Helper'}),null);

__d('sdk.XFBML.LoginButton',['sdk.Helper','IframePlugin','Log','sdk.ui'],__annotator(function $module_sdk_XFBML_LoginButton(global,require,requireDynamic,requireLazy,module,exports,Helper,IframePlugin,Log,ui){if(require.__markCompiled)require.__markCompiled();






var LoginButton=IframePlugin.extend({
constructor:__annotator(function(elem,ns,tag,
attr){return __bodyWrapper(this,arguments,function(){
this.parent(elem,ns,tag,attr);
var onlogin=IframePlugin.getVal(attr,'on_login');
var cb=null;

if(onlogin){
cb = __annotator(function(response){return __bodyWrapper(this,arguments,function(){
if(response.error_code){
Log.debug(
'Plugin Return Error (%s): %s',
response.error_code,
response.error_message || response.error_description);

return;}


Helper.invokeHandler(onlogin,null,[response]);},{params:[[response,'object','response']]});},{'module':'sdk.XFBML.LoginButton','line':21,'column':11,'endLine':32,'endColumn':7},{params:['object']});


this.subscribe('login.status',cb);}


this.subscribe('xd.login_button_native_open',__annotator(function(msg){
ui(ES('JSON','parse',false,msg.params),cb);},{'module':'sdk.XFBML.LoginButton','line':37,'column':50,'endLine':39,'endColumn':5}));},{params:[[elem,'HTMLElement','elem'],[ns,'string','ns'],[tag,'string','tag'],[attr,'object','attr']]});},{'module':'sdk.XFBML.LoginButton','line':14,'column':15,'endLine':40,'endColumn':3},{params:['HTMLElement','string','string','object']}),



getParams:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return {
scope:'string',
perms:'string',
size:'string',
login_text:'text',
show_faces:'bool',
max_rows:'string',
show_login_face:'bool',
registration_url:'url_maybe',
auto_logout_link:'bool',
one_click:'bool',
show_banner:'bool',
auth_type:'string',
default_audience:'string'};},{returns:'object'});},{'module':'sdk.XFBML.LoginButton','line':42,'column':13,'endLine':58,'endColumn':3},{returns:'object'})});




module.exports = LoginButton;},{'module':'sdk.XFBML.LoginButton','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_LoginButton'}),null);

__d('escapeHTML',[],__annotator(function $module_escapeHTML(global,require,requireDynamic,requireLazy,module,exports){if(require.__markCompiled)require.__markCompiled();

var re=/[&<>"'\/]/g;
var map={
'&':'&amp;',
'<':'&lt;',
'>':'&gt;',
'"':'&quot;',
"'":'&#039;',
'/':'&#x2F;'};


function escapeHTML(value){return __bodyWrapper(this,arguments,function(){
return value.replace(re,__annotator(function(m){
return map[m];},{'module':'escapeHTML','line':34,'column':27,'endLine':36,'endColumn':3}));},{params:[[value,'string','value']],returns:'string'});}__annotator(escapeHTML,{'module':'escapeHTML','line':33,'column':0,'endLine':37,'endColumn':1,'name':'escapeHTML'},{params:['string'],returns:'string'});


module.exports = escapeHTML;},{'module':'escapeHTML','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_escapeHTML'}),null);

__d('sdk.XFBML.Name',['ApiClient','escapeHTML','sdk.Event','sdk.XFBML.Element','sdk.Helper','Log','sdk.Runtime'],__annotator(function $module_sdk_XFBML_Name(global,require,requireDynamic,requireLazy,module,exports,ApiClient,escapeHTML,Event,Element,Helper,Log,Runtime){if(require.__markCompiled)require.__markCompiled();









var hasOwnProperty=({}).hasOwnProperty;

var Name=Element.extend({



process:__annotator(function(){
ES('Object','assign',false,this,{
_uid:this.getAttribute('uid'),
_firstnameonly:this._getBoolAttribute('first-name-only'),
_lastnameonly:this._getBoolAttribute('last-name-only'),
_possessive:this._getBoolAttribute('possessive'),
_reflexive:this._getBoolAttribute('reflexive'),
_objective:this._getBoolAttribute('objective'),
_linked:this._getBoolAttribute('linked',true),
_subjectId:this.getAttribute('subject-id')});


if(!this._uid){
Log.error('"uid" is a required attribute for <fb:name>');
this.fire('render');
return;}


var fields=[];
if(this._firstnameonly){
fields.push('first_name');}else
if(this._lastnameonly){
fields.push('last_name');}else
{
fields.push('name');}


if(this._subjectId){
fields.push('gender');

if(this._subjectId == Runtime.getUserID()){
this._reflexive = true;}}




Event.monitor('auth.statusChange',ES(__annotator(function(){

if(!this.isValid()){
this.fire('render');
return true;}


if(!this._uid || this._uid == 'loggedinuser'){
this._uid = Runtime.getUserID();}


if(!this._uid){
return;}


ApiClient.scheduleBatchCall(



'/v1.0/' + this._uid,
{fields:fields.join(',')},ES(__annotator(
function(data){
if(hasOwnProperty.call(data,'error')){
Log.warn('The name is not found for ID: ' + this._uid);
return;}

if(this._subjectId == this._uid){
this._renderPronoun(data);}else
{
this._renderOther(data);}

this.fire('render');},{'module':'sdk.XFBML.Name','line':79,'column':8,'endLine':90,'endColumn':9}),'bind',true,this));},{'module':'sdk.XFBML.Name','line':58,'column':39,'endLine':92,'endColumn':5}),'bind',true,this));},{'module':'sdk.XFBML.Name','line':22,'column':11,'endLine':93,'endColumn':3}),








_renderPronoun:__annotator(function(userInfo){return __bodyWrapper(this,arguments,function(){
var
word='',
objective=this._objective;
if(this._subjectId){
objective = true;
if(this._subjectId === this._uid){
this._reflexive = true;}}


if(this._uid == Runtime.getUserID() &&
this._getBoolAttribute('use-you',true)){
if(this._possessive){
if(this._reflexive){
word = 'your own';}else
{
word = 'your';}}else

{
if(this._reflexive){
word = 'yourself';}else
{
word = 'you';}}}else



{
switch(userInfo.gender){
case 'male':
if(this._possessive){
word = this._reflexive?'his own':'his';}else
{
if(this._reflexive){
word = 'himself';}else
if(objective){
word = 'him';}else
{
word = 'he';}}


break;
case 'female':
if(this._possessive){
word = this._reflexive?'her own':'her';}else
{
if(this._reflexive){
word = 'herself';}else
if(objective){
word = 'her';}else
{
word = 'she';}}


break;
default:
if(this._getBoolAttribute('use-they',true)){
if(this._possessive){
if(this._reflexive){
word = 'their own';}else
{
word = 'their';}}else

{
if(this._reflexive){
word = 'themselves';}else
if(objective){
word = 'them';}else
{
word = 'they';}}}else



{
if(this._possessive){
if(this._reflexive){
word = 'his/her own';}else
{
word = 'his/her';}}else

{
if(this._reflexive){
word = 'himself/herself';}else
if(objective){
word = 'him/her';}else
{
word = 'he/she';}}}



break;}}


if(this._getBoolAttribute('capitalize',false)){
word = Helper.upperCaseFirstChar(word);}

this.dom.innerHTML = word;},{params:[[userInfo,'object','userInfo']]});},{'module':'sdk.XFBML.Name','line':98,'column':18,'endLine':194,'endColumn':3},{params:['object']}),






_renderOther:__annotator(function(userInfo){return __bodyWrapper(this,arguments,function(){
var
name='',
html='';
if(this._uid == Runtime.getUserID() &&
this._getBoolAttribute('use-you',true)){
if(this._reflexive){
if(this._possessive){
name = 'your own';}else
{
name = 'yourself';}}else

{

if(this._possessive){
name = 'your';}else
{
name = 'you';}}}else



if(userInfo){

if(null === userInfo.first_name){
userInfo.first_name = '';}

if(null === userInfo.last_name){
userInfo.last_name = '';}





if(this._firstnameonly && userInfo.first_name !== undefined){
name = escapeHTML(userInfo.first_name);}else
if(this._lastnameonly && userInfo.last_name !== undefined){
name = escapeHTML(userInfo.last_name);}


if(!name){
name = escapeHTML(userInfo.name);}


if(name !== '' && this._possessive){
name += '\'s';}}



if(!name){
name = escapeHTML(
this.getAttribute('if-cant-see','Facebook User'));}

if(name){
if(this._getBoolAttribute('capitalize',false)){
name = Helper.upperCaseFirstChar(name);}

if(userInfo && this._linked){
html = Helper.getProfileLink(userInfo,name,
this.getAttribute('href',null));}else
{
html = name;}}


this.dom.innerHTML = html;},{params:[[userInfo,'object','userInfo']]});},{'module':'sdk.XFBML.Name','line':200,'column':16,'endLine':264,'endColumn':3},{params:['object']})});



module.exports = Name;},{'module':'sdk.XFBML.Name','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_Name'}),null);

__d('sdk.XFBML.ShareButton',['IframePlugin','sdk.ui'],__annotator(function $module_sdk_XFBML_ShareButton(global,require,requireDynamic,requireLazy,module,exports,IframePlugin,UI){

'use strict';if(require.__markCompiled)require.__markCompiled();




var ShareButton=IframePlugin.extend({
constructor:__annotator(function(
elem,
ns,
tag,
attr){return __bodyWrapper(this,arguments,function()
{
this.parent(elem,ns,tag,attr);
this.subscribe('xd.shareTriggerIframe',__annotator(function(message){
var data=ES('JSON','parse',false,message.data);

UI({
method:'share',
href:data.href,
iframe_test:true});},{'module':'sdk.XFBML.ShareButton','line':22,'column':44,'endLine':30,'endColumn':5}));},{params:[[ns,'string','ns'],[tag,'string','tag'],[attr,'object','attr']]});},{'module':'sdk.XFBML.ShareButton','line':15,'column':13,'endLine':32,'endColumn':3},{params:['string','string','object']}),





getParams:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return {
href:'url',
layout:'string',
type:'string'};},{returns:'object'});},{'module':'sdk.XFBML.ShareButton','line':34,'column':11,'endLine':40,'endColumn':3},{returns:'object'})});




module.exports = ShareButton;},{'module':'sdk.XFBML.ShareButton','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_ShareButton'}),null);

__d('sdk.XFBML.Video',['Assert','sdk.Event','IframePlugin','ObservableMixin','sdk.XD'],__annotator(function $module_sdk_XFBML_Video(global,require,requireDynamic,requireLazy,module,exports,Assert,Event,IframePlugin,ObservableMixin,XD){if(require.__markCompiled)require.__markCompiled();






























function VideoCache(initData){return __bodyWrapper(this,arguments,function(){'use strict';
this.$VideoCache_isMuted = initData.isMuted;
this.$VideoCache_volume = initData.volume;
this.$VideoCache_timePosition = initData.timePosition;
this.$VideoCache_duration = initData.duration;},{params:[[initData,'object','initData']]});}__annotator(VideoCache,{'module':'sdk.XFBML.Video','line':39,'column':2,'endLine':44,'endColumn':3,'name':'VideoCache'},{params:['object']});VideoCache.prototype.


update = __annotator(function(data){return __bodyWrapper(this,arguments,function(){'use strict';
if(data.isMuted !== undefined){
this.$VideoCache_isMuted = data.isMuted;}

if(data.volume !== undefined){
this.$VideoCache_volume = data.volume;}

if(data.timePosition !== undefined){
this.$VideoCache_timePosition = data.timePosition;}

if(data.duration !== undefined){
this.$VideoCache_duration = data.duration;}},{params:[[data,'object','data']]});},{'module':'sdk.XFBML.Video','line':46,'column':8,'endLine':59,'endColumn':3},{params:['object']});VideoCache.prototype.



isMuted = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoCache_isMuted;},{returns:'boolean'});},{'module':'sdk.XFBML.Video','line':61,'column':9,'endLine':63,'endColumn':3},{returns:'boolean'});VideoCache.prototype.


getVolume = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoCache_isMuted?0:this.$VideoCache_volume;},{returns:'number'});},{'module':'sdk.XFBML.Video','line':65,'column':11,'endLine':67,'endColumn':3},{returns:'number'});VideoCache.prototype.


getCurrentPosition = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoCache_timePosition;},{returns:'number'});},{'module':'sdk.XFBML.Video','line':69,'column':20,'endLine':71,'endColumn':3},{returns:'number'});VideoCache.prototype.


getDuration = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoCache_duration;},{returns:'number'});},{'module':'sdk.XFBML.Video','line':73,'column':13,'endLine':75,'endColumn':3},{returns:'number'});










function VideoController(
iframeName,
observableMixin,
cache){return __bodyWrapper(this,arguments,function()
{'use strict';
this.$VideoController_iframeName = iframeName;
this.$VideoController_sharedObservable = observableMixin;
this.$VideoController_cache = cache;},{params:[[iframeName,'string','iframeName'],[observableMixin,'ObservableMixin','observableMixin'],[cache,'VideoCache','cache']]});}__annotator(VideoController,{'module':'sdk.XFBML.Video','line':85,'column':2,'endLine':93,'endColumn':3,'name':'VideoController'},{params:['string','ObservableMixin','VideoCache']});VideoController.prototype.


play = __annotator(function(){'use strict';
XD.sendToFacebook(this.$VideoController_iframeName,{
method:'play',
params:ES('JSON','stringify',false,{})});},{'module':'sdk.XFBML.Video','line':95,'column':6,'endLine':100,'endColumn':3});VideoController.prototype.



pause = __annotator(function(){'use strict';
XD.sendToFacebook(this.$VideoController_iframeName,{
method:'pause',
params:ES('JSON','stringify',false,{})});},{'module':'sdk.XFBML.Video','line':102,'column':7,'endLine':107,'endColumn':3});VideoController.prototype.




seek = __annotator(function(target){return __bodyWrapper(this,arguments,function(){'use strict';
Assert.isNumber(target,'Invalid argument');
XD.sendToFacebook(this.$VideoController_iframeName,{
method:'seek',
params:ES('JSON','stringify',false,{
target:target})});},{params:[[target,'number','target']]});},{'module':'sdk.XFBML.Video','line':110,'column':6,'endLine':118,'endColumn':3},{params:['number']});VideoController.prototype.




mute = __annotator(function(){'use strict';
XD.sendToFacebook(this.$VideoController_iframeName,{
method:'mute',
params:ES('JSON','stringify',false,{})});},{'module':'sdk.XFBML.Video','line':120,'column':6,'endLine':125,'endColumn':3});VideoController.prototype.



unmute = __annotator(function(){'use strict';
XD.sendToFacebook(this.$VideoController_iframeName,{
method:'unmute',
params:ES('JSON','stringify',false,{})});},{'module':'sdk.XFBML.Video','line':127,'column':8,'endLine':132,'endColumn':3});VideoController.prototype.




setVolume = __annotator(function(volume){return __bodyWrapper(this,arguments,function(){'use strict';
Assert.isNumber(volume,'Invalid argument');
XD.sendToFacebook(this.$VideoController_iframeName,{
method:'setVolume',
params:ES('JSON','stringify',false,{
volume:volume})});},{params:[[volume,'number','volume']]});},{'module':'sdk.XFBML.Video','line':135,'column':11,'endLine':143,'endColumn':3},{params:['number']});VideoController.prototype.




isMuted = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoController_cache.isMuted();},{returns:'boolean'});},{'module':'sdk.XFBML.Video','line':145,'column':9,'endLine':147,'endColumn':3},{returns:'boolean'});VideoController.prototype.


getVolume = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoController_cache.getVolume();},{returns:'number'});},{'module':'sdk.XFBML.Video','line':149,'column':11,'endLine':151,'endColumn':3},{returns:'number'});VideoController.prototype.


getCurrentPosition = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoController_cache.getCurrentPosition();},{returns:'number'});},{'module':'sdk.XFBML.Video','line':153,'column':20,'endLine':155,'endColumn':3},{returns:'number'});VideoController.prototype.


getDuration = __annotator(function(){return __bodyWrapper(this,arguments,function(){'use strict';
return this.$VideoController_cache.getDuration();},{returns:'number'});},{'module':'sdk.XFBML.Video','line':157,'column':13,'endLine':159,'endColumn':3},{returns:'number'});VideoController.prototype.


subscribe = __annotator(function(event,callback){return __bodyWrapper(this,arguments,function(){'use strict';
Assert.isString(event,'Invalid argument');
Assert.isFunction(callback,'Invalid argument');
this.$VideoController_sharedObservable.subscribe(event,callback);
return {
release:ES(__annotator(function(){
this.$VideoController_sharedObservable.unsubscribe(event,callback);},{'module':'sdk.XFBML.Video','line':166,'column':15,'endLine':168,'endColumn':7}),'bind',true,this)};},{params:[[event,'string','event'],[callback,'function','callback']]});},{'module':'sdk.XFBML.Video','line':161,'column':11,'endLine':170,'endColumn':3},{params:['string','function']});





var Video=IframePlugin.extend({
constructor:__annotator(function(
elem,
ns,
tag,
attr){return __bodyWrapper(this,arguments,function()
{
this.parent(elem,ns,tag,attr);
this._videoController = null;
this._sharedObservable = null;
this._sharedVideoCache = null;
this.subscribe('xd.onVideoAPIReady',__annotator(function(msg){
this._sharedObservable = new ObservableMixin();
this._sharedVideoCache = new VideoCache(ES('JSON','parse',false,msg.data));
this._videoController = new VideoController(
this._iframeOptions.name,
this._sharedObservable,
this._sharedVideoCache);

Event.fire('xfbml.ready',{
type:'video',
id:attr.id,
instance:this._videoController});},{'module':'sdk.XFBML.Video','line':184,'column':41,'endLine':197,'endColumn':5}));


this.subscribe('xd.stateChange',__annotator(function(msg){
this._sharedObservable.inform(msg.state);},{'module':'sdk.XFBML.Video','line':198,'column':37,'endLine':200,'endColumn':5}));

this.subscribe('xd.cachedStateUpdateRequest',__annotator(function(msg){
this._sharedVideoCache.update(ES('JSON','parse',false,msg.data));},{'module':'sdk.XFBML.Video','line':201,'column':50,'endLine':203,'endColumn':5}));},{params:[[ns,'string','ns'],[tag,'string','tag'],[attr,'object','attr']]});},{'module':'sdk.XFBML.Video','line':174,'column':14,'endLine':204,'endColumn':3},{params:['string','string','object']}),



getParams:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return {
allowfullscreen:'bool',
autoplay:'bool',
controls:'bool',
href:'url'};},{returns:'object'});},{'module':'sdk.XFBML.Video','line':206,'column':11,'endLine':213,'endColumn':3},{returns:'object'}),



getConfig:__annotator(function(){return __bodyWrapper(this,arguments,function(){
return {
fluid:true,
full_width:true};},{returns:'object'});},{'module':'sdk.XFBML.Video','line':215,'column':11,'endLine':220,'endColumn':3},{returns:'object'})});




module.exports = Video;},{'module':'sdk.XFBML.Video','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_sdk_XFBML_Video'}),null);

__d('legacy:fb.xfbml',['Assert','sdk.Event','FB','IframePlugin','PluginConfig','PluginTags','XFBML','sdk.domReady','sdk.feature','wrapFunction','sdk.XFBML.Comments','sdk.XFBML.CommentsCount','sdk.XFBML.LoginButton','sdk.XFBML.Name','sdk.XFBML.ShareButton','sdk.XFBML.Video'],__annotator(function $module_legacy_fb_xfbml(global,require,requireDynamic,requireLazy,__DO_NOT_USE__module,__DO_NOT_USE__exports,Assert,Event,FB,IframePlugin,PluginConfig,PluginTags,XFBML,domReady,feature,wrapFunction){if(require.__markCompiled)require.__markCompiled();













var customTags={
comments:require('sdk.XFBML.Comments'),
comments_count:require('sdk.XFBML.CommentsCount'),
login_button:require('sdk.XFBML.LoginButton'),
name:require('sdk.XFBML.Name'),
share_button:require('sdk.XFBML.ShareButton'),
video:require('sdk.XFBML.Video')};


var blacklist=feature('plugin_tags_blacklist',[]);


ES(ES('Object','keys',false,PluginTags),'forEach',true,__annotator(function(tag){
if(ES(blacklist,'indexOf',true,tag) !== -1){
return;}

XFBML.registerTag({
xmlns:'fb',
localName:tag.replace(/_/g,'-'),
ctor:IframePlugin.withParams(PluginTags[tag],PluginConfig[tag])});},{'module':'legacy:fb.xfbml','line':31,'column':32,'endLine':40,'endColumn':1}));




ES(ES('Object','keys',false,customTags),'forEach',true,__annotator(function(tag){
if(ES(blacklist,'indexOf',true,tag) !== -1){
return;}

XFBML.registerTag({
xmlns:'fb',
localName:tag.replace(/_/g,'-'),
ctor:customTags[tag]});},{'module':'legacy:fb.xfbml','line':43,'column':32,'endLine':52,'endColumn':1}));



FB.provide('XFBML',{
parse:__annotator(function(dom){
Assert.maybeXfbml(dom,'Invalid argument');


if(dom && dom.nodeType === 9){
dom = dom.body;}

return XFBML.parse.apply(null,arguments);},{'module':'legacy:fb.xfbml','line':55,'column':9,'endLine':63,'endColumn':3})});



XFBML.subscribe('parse',ES(Event.fire,'bind',true,Event,'xfbml.parse'));
XFBML.subscribe('render',ES(Event.fire,'bind',true,Event,'xfbml.render'));

Event.subscribe('init:post',__annotator(function(options){
if(options.xfbml){

setTimeout(
wrapFunction(ES(
domReady,'bind',true,null,XFBML.parse),
'entry',
'init:post:xfbml.parse'),

0);}},{'module':'legacy:fb.xfbml','line':69,'column':29,'endLine':81,'endColumn':1}));




Assert.define('Xfbml',__annotator(function(element){
return (element.nodeType === 1 || element.nodeType === 9) &&
typeof element.nodeName === 'string';},{'module':'legacy:fb.xfbml','line':83,'column':23,'endLine':86,'endColumn':1}));








try{
if(document.namespaces && !document.namespaces.item.fb){
document.namespaces.add('fb');}}

catch(e) {}},{'module':'legacy:fb.xfbml','line':0,'column':0,'endLine':0,'endColumn':0,'name':'$module_legacy_fb_xfbml'}),3);

    }  }).call(global);})(window.inDapIF ? parent.window : window, window);} catch (e) {new Image().src="https:\/\/www.facebook.com\/" + 'common/scribe_endpoint.php?c=jssdk_error&m='+encodeURIComponent('{"error":"LOAD", "extra": {"name":"'+e.name+'","line":"'+(e.lineNumber||e.line)+'","script":"'+(e.fileName||e.sourceURL||e.script)+'","stack":"'+(e.stackTrace||e.stack)+'","revision":"2138186","namespace":"FB","message":"'+e.message+'"}}');}