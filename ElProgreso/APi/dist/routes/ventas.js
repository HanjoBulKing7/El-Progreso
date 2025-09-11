"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var express_1 = require("express");
var pedidos_controller_1 = require("../controller/pedidos.controller");
var ventasRutas = (0, express_1.Router)();
ventasRutas.post('/createPedido', pedidos_controller_1.postCreatePedido);
// val URLGuardaProductos = "https://api.dazug.com.mx/ventas/registrarVenta"
ventasRutas.post('/registrarVenta', pedidos_controller_1.crearVenta);
exports.default = ventasRutas;
