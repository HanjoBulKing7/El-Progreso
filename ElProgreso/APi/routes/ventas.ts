import { Router } from 'express';
import { crearVenta, postCreatePedido } from '../controller/pedidos.controller';



const ventasRutas = Router();


ventasRutas.post('/createPedido', postCreatePedido);

// val URLGuardaProductos = "https://api.dazug.com.mx/ventas/registrarVenta"
ventasRutas.post('/registrarVenta',crearVenta)



export default ventasRutas; 