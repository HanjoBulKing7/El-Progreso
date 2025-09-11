"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var express_1 = require("express");
var express_validator_1 = require("express-validator");
var prodctos_controller_1 = require("../controller/prodctos.controller");
var validar_campos_1 = require("../middlewares/validar-campos");
var productosRuta = (0, express_1.Router)();
// val URLALlProductos = "https://api.dazug.com.mx/productos/getProductosxRuta?"
productosRuta.get('/getProductosxRuta', [
    (0, express_validator_1.check)('id_ruta', 'Es necesaria la Ruta').notEmpty(),
    validar_campos_1.validarCampos
], prodctos_controller_1.getProductosRuta);
productosRuta.get('/getAllProductos', prodctos_controller_1.getAllProductos);
exports.default = productosRuta;
