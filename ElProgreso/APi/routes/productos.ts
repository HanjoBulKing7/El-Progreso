import { Router } from 'express';
import { check } from 'express-validator';
import { getAllProductos, getProductosRuta } from '../controller/prodctos.controller';
import { validarCampos } from '../middlewares/validar-campos';

const productosRuta = Router();

// val URLALlProductos = "https://api.dazug.com.mx/productos/getProductosxRuta?"
productosRuta.get('/getProductosxRuta', [
    check('id_ruta','Es necesaria la Ruta').notEmpty(),
    validarCampos
] ,getProductosRuta);



productosRuta.get('/getAllProductos', getAllProductos);


export default productosRuta;