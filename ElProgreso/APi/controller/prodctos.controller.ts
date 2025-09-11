import { Request, Response } from 'express';
import Conexion from '../classes/conn';

const conexion = new Conexion()

const getAllProductos = async ( req: Request, res: Response) => {
    // let pagina = Number(req.query.pagina) || 1;
    // let skip = pagina - 1;
    // skip = skip * 10;
    // LIMIT 10 OFFSET ${skip}
    
    const results = await conexion.conexionLocal(`SELECT id,nombre, descripcion, tipo_productos.nombre_produc AS tipo, precio_venta, precio_mayoreo, precio_menudeo, existencia FROM productos
    INNER JOIN tipo_productos ON tipo_productos.id_tipo = productos.fktipo
    WHERE existencia > 0 AND 
    estatus_produ = 1 ;`)

    res.status(200).json({
        ok: true,
        mensaje: 'Todo bien',
        productos: results
    })

}

// val URLALlProductos = "https://api.dazug.com.mx/productos/getProductosxRuta?"
const getProductosRuta = async (req: Request, res: Response) => {
    const id_ruta = req.query.id_ruta;

    const results = await conexion.conexionLocal(`SELECT id_producto, cantidad, nombre, descripcion, precio_venta, precio_mayoreo, precio_menudeo FROM inventario_rutas
    INNER JOIN productos ON inventario_rutas.id_producto = productos.id
    WHERE inventario_rutas.id_ruta = ${id_ruta};`)
    
    res.json({
        ok: true, 
        mensaje: 'funciona bien',
        productos: results
    })
}


export {
    getAllProductos,
    getProductosRuta,
}
    
