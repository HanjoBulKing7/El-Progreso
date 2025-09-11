import { Request, Response } from 'express';
import Conexion from '../classes/conn';
import moment from 'moment';

const conexion = new Conexion()

//  val URLGetRutaxIDRuta= "https://api.dazug.com.mx/rutas/getrutaxidruta?"
/**
 * @function getRutaXIdRuta
 * @description Consulta las tiendas asociadas a una ruta específica con paginación.
 * @route GET /api/ruta?id_ruta=123&pagina=1
 * @query { id_ruta: number, pagina?: number }
 * @returns { ok: boolean, productos: any[] }
 */
const getRutaXIdRuta = async (req: Request, res: Response): Promise<void> => {
  try {
    const id_ruta = req.query.id_ruta;
    const diasemanaRaw = req.query.dia as string | undefined;
    let dia: string;

    // Obtener día de la semana
    if (diasemanaRaw && diasemanaRaw.trim() !== '') {
      dia = diasemanaRaw.trim().toLowerCase();
    } else {
      const fecha = new Date();
      dia = new Intl.DateTimeFormat('es-MX', { weekday: 'long' }).format(fecha).toLowerCase();
    }

    // Validar que se recibió un id_ruta válido
    if (!id_ruta || isNaN(Number(id_ruta))) {
      return res.status(400).json({
        ok: false,
        mensaje: 'El parámetro id_ruta es obligatorio y debe ser numérico'
      });
    }

    // Consulta SQL sin paginación
    const query = `
      SELECT 
        fk_tienda,
        dias_visita_tienda,
        orden_visita,
        tiendas.nombre_tienda,
        tiendas.fk_codigo_postal,
        tiendas.colonia,
        tiendas.direccion_tienda,
        tiendas.responsable_tienda,
        tiendas.tel_tienda
      FROM ruta_tiendas
      INNER JOIN tiendas ON ruta_tiendas.fk_tienda = tiendas.id
      WHERE ruta_tiendas.fk_ruta = ? AND ruta_tiendas.status_tienda_ruta = 1
      AND dias_visita_tienda LIKE ?
      ORDER BY orden_visita DESC;
    `;

    const results = await conexion.conexionLocal(query, [id_ruta, `%${dia}%`]);

    res.status(200).json({
      ok: true,
      dia,
      tiendas: results
    });
  } catch (error: any) {
    console.error('Error al obtener ruta por ID:', error.message);
    res.status(500).json({
      ok: false,
      mensaje: 'Error interno del servidor',
      error: error.message
    });
  }
};

//   val URLRegistraTura=   "https://api.dazug.com.mx/rutas/resgitrarRuta"
/**
 * @function crearRegistroVisita
 * @description Registra una nueva visita a una tienda dentro de una ruta específica.
 * @route POST /api/visitas
 * @body { id_ruta, id_tienda, fecha_reg, hora_reg, lat, lng }
 * @returns { ok: boolean, mensaje: string }
 */
const crearRegistroVisita = async (req: Request, res: Response): Promise<void> => {
  try {
    const { id_ruta, id_tienda, fecha_reg, hora_reg, lat, lng } = req.body;

    // Validación básica de entrada
    if (!id_ruta || !id_tienda || !fecha_reg || !hora_reg || !lat || !lng) {
      return res.status(400).json({
        ok: false,
        mensaje: 'Todos los campos son obligatorios'
      });
    }

    // Consulta segura utilizando parámetros para prevenir inyección SQL
    const query = `
      INSERT INTO registro_ruta_check (
        id_ruta, fecha_registro, hora_registro, id_tienda, lat, lng
      ) VALUES (?, ?, ?, ?, ?, ?)
    `;

    const values = [id_ruta, fecha_reg, hora_reg, id_tienda, lat, lng];

    const results = await conexion.conexionLocal(query, values);

    // Verificar que se haya insertado correctamente (usando affectedRows si está disponible)
    if (results && (results as any).affectedRows > 0) {
      res.status(201).json({
        ok: true,
        mensaje: 'Registro de visita creado correctamente'
      });
    } else {
      res.status(500).json({
        ok: false,
        mensaje: 'No se pudo crear el registro de visita'
      });
    }
  } catch (error: any) {
    console.error('Error al crear registro de visita:', error);
    res.status(500).json({
      ok: false,
      mensaje: 'Error interno del servidor',
      error: error.message
    });
  }
};

/**
 * @function crearTiendaController
 * @description Crea una nueva tienda en la base de datos utilizando datos proporcionados en el body del request.
 * @route POST /api/tiendas
 * @body { nombre_tienda, fk_codigo_postal, colonia, direccion_tienda, responsable_tienda }
 * @returns Respuesta JSON indicando éxito o error
 */
const crearTiendaController = async (req: Request, res: Response): Promise<void> => {
  try {
    // Desestructurar los datos del body
    const {
      nombre_tienda,
      fk_codigo_postal,
      colonia,
      direccion_tienda,
      responsable_tienda
    } = req.body;

    // Validación básica
    if (!nombre_tienda || !fk_codigo_postal || !colonia || !direccion_tienda || !responsable_tienda) {
      return res.status(400).json({
        ok: false,
        mensaje: 'Faltan datos obligatorios en el cuerpo de la petición'
      });
    }

    // Query SQL segura con parámetros
    const query = `
      INSERT INTO tiendas (
        nombre_tienda,
        fk_codigo_postal,
        colonia,
        direccion_tienda,
        responsable_tienda
      ) VALUES (?, ?, ?, ?, ?)
    `;

    const values = [
      nombre_tienda,
      fk_codigo_postal,
      colonia,
      direccion_tienda,
      responsable_tienda
    ];

    const results: any = await conexion.conexionLocal(query, values);

    // Validar resultados y responder
    if (results && results.affectedRows > 0) {
      res.status(201).json({
        ok: true,
        mensaje: 'Tienda creada exitosamente'
      });
    } else {
      res.status(500).json({
        ok: false,
        mensaje: 'Error al registrar la tienda'
      });
    }
  } catch (error: any) {
    console.error('Error al crear tienda:', error.message);
    res.status(500).json({
      ok: false,
      mensaje: 'Error interno del servidor',
      error: error.message
    });
  }
};

/**
 * @function getdiassemana
 * @description Consulta los días de la semana asociados a una ruta específica.
 * @route GET /api/diassemana?id_ruta=123
 * @param {string} id_ruta - ID de la ruta a consultar (query param)
 * @returns Lista de días asociados a la ruta o error si no se encuentra
 */
const getdiassemana = async (req: Request, res: Response): Promise<void> => {
  try {
    const { id_ruta } = req.query;

    // Validación básica
    if (!id_ruta) {
      res.status(400).json({
        ok: false,
        mensaje: 'Parámetro id_ruta requerido'
      });
      return;
    }

    // Obtener la fecha actual en formato YYYY-MM-DD
    const fechaActual = moment().format('YYYY-MM-DD');

    // Obtener el ID de la semana que contiene la fecha actual
    const semanaQuery = `
      SELECT id FROM semanas 
      WHERE ? BETWEEN inicio AND fin
      LIMIT 1;
    `;
    const semanaResult: any = await conexion.conexionLocal(semanaQuery, [fechaActual]);

    if (!semanaResult || semanaResult.length === 0) {
      res.status(404).json({
        ok: false,
        mensaje: 'No se encontró una semana activa para la fecha actual'
      });
      return;
    }

    const id_semana = semanaResult[0].id;

    // Previene inyección SQL usando parámetros seguros
    const results: any = await conexion.conexionLocal(
      'SELECT * FROM dias_semana WHERE ruta_id = ? AND semana_id = ?;',
      [id_ruta, id_semana]
    );

    if (results && results.length > 0) {
      res.status(200).json({
        ok: true,
        id_semana,
        results
      });
    } else {
      res.status(404).json({
        ok: false,
        mensaje: 'No se encontraron días para la ruta especificada'
      });
    }
  } catch (error: any) {
    console.error('Error en getdiassemana:', error.message);
    res.status(500).json({
      ok: false,
      mensaje: 'Error interno del servidor',
      error: error.message
    });
  }
};


export {
    getRutaXIdRuta,
    crearRegistroVisita,
    crearTiendaController,
    getdiassemana
}
    
