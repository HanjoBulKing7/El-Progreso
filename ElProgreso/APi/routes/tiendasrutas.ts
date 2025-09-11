import { Router } from 'express';
import { crearRegistroVisita, crearTiendaController, getdiassemana, getRutaXIdRuta } from '../controller/tiendasrutas.controller';
import { check } from 'express-validator';
import { validarCampos } from '../middlewares/validar-campos';

const tiendasRutas = Router();


tiendasRutas.get('/getrutaxidruta',
[
    check('id_ruta','Es necesaria la Ruta').notEmpty(),
    validarCampos
]
,getRutaXIdRuta)

tiendasRutas.post('/resgitrarruta',[
    check('id_ruta','Es necesaria la Ruta').notEmpty(),
    check('id_tienda','Es necesaria la Tienda').notEmpty(),
    check('fecha_reg','Es necesaria la Fecha').notEmpty(),
    check('hora_reg','Es necesaria la Hora').notEmpty(),
    check('lat','Es necesaria la Latitud').notEmpty(),
    check('lng','Es necesaria la Longitud').notEmpty(),
    validarCampos
],crearRegistroVisita)

tiendasRutas.post('/creartienda',[
    check('nombre_tienda').notEmpty(),
    check('fk_codigo_postal').notEmpty(),
    check('colonia').notEmpty(),
    check('direccion_tienda').notEmpty(),
    check('responsable_tienda').notEmpty()
], crearTiendaController)

tiendasRutas.get('/getdias',
[
    check('id_ruta','Es necesaria la Ruta').notEmpty(),
    validarCampos
]
,getdiassemana)



export default tiendasRutas; 