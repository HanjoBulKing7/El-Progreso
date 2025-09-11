"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var express_1 = require("express");
var tiendasrutas_controller_1 = require("../controller/tiendasrutas.controller");
var express_validator_1 = require("express-validator");
var validar_campos_1 = require("../middlewares/validar-campos");
var tiendasRutas = (0, express_1.Router)();
tiendasRutas.get('/getrutaxidruta', [
    (0, express_validator_1.check)('id_ruta', 'Es necesaria la Ruta').notEmpty(),
    validar_campos_1.validarCampos
], tiendasrutas_controller_1.getRutaXIdRuta);
tiendasRutas.post('/resgitrarruta', [
    (0, express_validator_1.check)('id_ruta', 'Es necesaria la Ruta').notEmpty(),
    (0, express_validator_1.check)('id_tienda', 'Es necesaria la Tienda').notEmpty(),
    (0, express_validator_1.check)('fecha_reg', 'Es necesaria la Fecha').notEmpty(),
    (0, express_validator_1.check)('hora_reg', 'Es necesaria la Hora').notEmpty(),
    (0, express_validator_1.check)('lat', 'Es necesaria la Latitud').notEmpty(),
    (0, express_validator_1.check)('lng', 'Es necesaria la Longitud').notEmpty(),
    validar_campos_1.validarCampos
], tiendasrutas_controller_1.crearRegistroVisita);
tiendasRutas.post('/creartienda', [
    (0, express_validator_1.check)('nombre_tienda').notEmpty(),
    (0, express_validator_1.check)('fk_codigo_postal').notEmpty(),
    (0, express_validator_1.check)('colonia').notEmpty(),
    (0, express_validator_1.check)('direccion_tienda').notEmpty(),
    (0, express_validator_1.check)('responsable_tienda').notEmpty()
], tiendasrutas_controller_1.crearTiendaController);
tiendasRutas.get('/getdias', [
    (0, express_validator_1.check)('id_ruta', 'Es necesaria la Ruta').notEmpty(),
    validar_campos_1.validarCampos
], tiendasrutas_controller_1.getdiassemana);
exports.default = tiendasRutas;
