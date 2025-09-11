import { Request, Response } from 'express';
import Conexion from '../classes/conn';


const conexion = new Conexion();

const postCreatePedido = async (req: Request, res: Response) => {
    const {id_ruta, productos} = req.body;
    let total: Number
    productos.forEach(element => {
        total = Number(element['cantidad']) * Number(element['costo'])

        conexion.conexionLocal(`INSERT INTO pedidos_app (id_ruta_pedido, cantidad_pedido, id_producto_pedido,costo_pedido,total_pedido) VALUES (${id_ruta}, ${element['cantidad']}, ${element['id_producto']}, ${element['costo']}, ${total} )`)

        total = 0;
    });

    res.json({
        ok: true,
        mensaje: 'Pedido Creado'
    })
}

// val URLGuardaProductos = "https://api.dazug.com.mx/ventas/registrarVenta"
const crearVenta = async ( req: Request, res: Response ) => {
    const { id_ruta, productos,dispositivo } = req.body
    let total: Number, subtotal: Number
    for (const producto of productos) {
        total = Number(producto['cantidad']) * Number(producto['costo']);
        subtotal = total;
    
        try {
            const updateInventario:any = await conexion.conexionLocal(`UPDATE inventario_rutas SET cantidad = cantidad - ${producto['cantidad']} WHERE id_ruta = ${id_ruta} AND id_producto = ${producto['id_producto']}`);
    
            const result: any = await conexion.conexionLocal(`INSERT INTO venta_x_rutas (id_ruta, id_producto, cantidad, costo, subtotal, total, tipo_movi, dispositivo) VALUES (${id_ruta}, ${producto['id_producto']}, ${producto['cantidad']}, ${producto['costo']}, ${total}, ${total}, '${producto['tipo_movi']}', '${dispositivo}' )`);
            
            if (updateInventario.affectedRows === 1 && result.affectedRows === 1) {
                console.log(`Producto ${producto['id_producto']} actualizado y vendido correctamente.`);
            } else {
                console.log(`Hubo un problema al actualizar o vender el producto ${producto['id_producto']}.`);
            }
        } catch (error:any) {
            console.error(`Error al ejecutar la consulta: ${error.message}`);
            return res.status(500).json({
                ok: false,
                mensaje: 'Hubo un error al procesar la solicitud.'
            });
        }
    }

    return res.status(200).json({
        ok: true,
        mensaje: 'Ventas realizadas con éxito.'
    });
}


export {
    postCreatePedido,
    crearVenta
}