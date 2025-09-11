"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (g && (g = 0, op[0] && (_ = 0)), _) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.getdiassemana = exports.crearTiendaController = exports.crearRegistroVisita = exports.getRutaXIdRuta = void 0;
var conn_1 = __importDefault(require("../classes/conn"));
var moment_1 = __importDefault(require("moment"));
var conexion = new conn_1.default();
//  val URLGetRutaxIDRuta= "https://api.dazug.com.mx/rutas/getrutaxidruta?"
/**
 * @function getRutaXIdRuta
 * @description Consulta las tiendas asociadas a una ruta específica con paginación.
 * @route GET /api/ruta?id_ruta=123&pagina=1
 * @query { id_ruta: number, pagina?: number }
 * @returns { ok: boolean, productos: any[] }
 */
var getRutaXIdRuta = function (req, res) { return __awaiter(void 0, void 0, void 0, function () {
    var id_ruta, diasemanaRaw, dia, fecha, query, results, error_1;
    return __generator(this, function (_a) {
        switch (_a.label) {
            case 0:
                _a.trys.push([0, 2, , 3]);
                id_ruta = req.query.id_ruta;
                diasemanaRaw = req.query.dia;
                dia = void 0;
                // Obtener día de la semana
                if (diasemanaRaw && diasemanaRaw.trim() !== '') {
                    dia = diasemanaRaw.trim().toLowerCase();
                }
                else {
                    fecha = new Date();
                    dia = new Intl.DateTimeFormat('es-MX', { weekday: 'long' }).format(fecha).toLowerCase();
                }
                // Validar que se recibió un id_ruta válido
                if (!id_ruta || isNaN(Number(id_ruta))) {
                    return [2 /*return*/, res.status(400).json({
                            ok: false,
                            mensaje: 'El parámetro id_ruta es obligatorio y debe ser numérico'
                        })];
                }
                query = "\n      SELECT \n        fk_tienda,\n        dias_visita_tienda,\n        orden_visita,\n        tiendas.nombre_tienda,\n        tiendas.fk_codigo_postal,\n        tiendas.colonia,\n        tiendas.direccion_tienda,\n        tiendas.responsable_tienda,\n        tiendas.tel_tienda\n      FROM ruta_tiendas\n      INNER JOIN tiendas ON ruta_tiendas.fk_tienda = tiendas.id\n      WHERE ruta_tiendas.fk_ruta = ? AND ruta_tiendas.status_tienda_ruta = 1\n      AND dias_visita_tienda LIKE ?\n      ORDER BY orden_visita DESC;\n    ";
                return [4 /*yield*/, conexion.conexionLocal(query, [id_ruta, "%".concat(dia, "%")])];
            case 1:
                results = _a.sent();
                res.status(200).json({
                    ok: true,
                    dia: dia,
                    tiendas: results
                });
                return [3 /*break*/, 3];
            case 2:
                error_1 = _a.sent();
                console.error('Error al obtener ruta por ID:', error_1.message);
                res.status(500).json({
                    ok: false,
                    mensaje: 'Error interno del servidor',
                    error: error_1.message
                });
                return [3 /*break*/, 3];
            case 3: return [2 /*return*/];
        }
    });
}); };
exports.getRutaXIdRuta = getRutaXIdRuta;
//   val URLRegistraTura=   "https://api.dazug.com.mx/rutas/resgitrarRuta"
/**
 * @function crearRegistroVisita
 * @description Registra una nueva visita a una tienda dentro de una ruta específica.
 * @route POST /api/visitas
 * @body { id_ruta, id_tienda, fecha_reg, hora_reg, lat, lng }
 * @returns { ok: boolean, mensaje: string }
 */
var crearRegistroVisita = function (req, res) { return __awaiter(void 0, void 0, void 0, function () {
    var _a, id_ruta, id_tienda, fecha_reg, hora_reg, lat, lng, query, values, results, error_2;
    return __generator(this, function (_b) {
        switch (_b.label) {
            case 0:
                _b.trys.push([0, 2, , 3]);
                _a = req.body, id_ruta = _a.id_ruta, id_tienda = _a.id_tienda, fecha_reg = _a.fecha_reg, hora_reg = _a.hora_reg, lat = _a.lat, lng = _a.lng;
                // Validación básica de entrada
                if (!id_ruta || !id_tienda || !fecha_reg || !hora_reg || !lat || !lng) {
                    return [2 /*return*/, res.status(400).json({
                            ok: false,
                            mensaje: 'Todos los campos son obligatorios'
                        })];
                }
                query = "\n      INSERT INTO registro_ruta_check (\n        id_ruta, fecha_registro, hora_registro, id_tienda, lat, lng\n      ) VALUES (?, ?, ?, ?, ?, ?)\n    ";
                values = [id_ruta, fecha_reg, hora_reg, id_tienda, lat, lng];
                return [4 /*yield*/, conexion.conexionLocal(query, values)];
            case 1:
                results = _b.sent();
                // Verificar que se haya insertado correctamente (usando affectedRows si está disponible)
                if (results && results.affectedRows > 0) {
                    res.status(201).json({
                        ok: true,
                        mensaje: 'Registro de visita creado correctamente'
                    });
                }
                else {
                    res.status(500).json({
                        ok: false,
                        mensaje: 'No se pudo crear el registro de visita'
                    });
                }
                return [3 /*break*/, 3];
            case 2:
                error_2 = _b.sent();
                console.error('Error al crear registro de visita:', error_2);
                res.status(500).json({
                    ok: false,
                    mensaje: 'Error interno del servidor',
                    error: error_2.message
                });
                return [3 /*break*/, 3];
            case 3: return [2 /*return*/];
        }
    });
}); };
exports.crearRegistroVisita = crearRegistroVisita;
/**
 * @function crearTiendaController
 * @description Crea una nueva tienda en la base de datos utilizando datos proporcionados en el body del request.
 * @route POST /api/tiendas
 * @body { nombre_tienda, fk_codigo_postal, colonia, direccion_tienda, responsable_tienda }
 * @returns Respuesta JSON indicando éxito o error
 */
var crearTiendaController = function (req, res) { return __awaiter(void 0, void 0, void 0, function () {
    var _a, nombre_tienda, fk_codigo_postal, colonia, direccion_tienda, responsable_tienda, query, values, results, error_3;
    return __generator(this, function (_b) {
        switch (_b.label) {
            case 0:
                _b.trys.push([0, 2, , 3]);
                _a = req.body, nombre_tienda = _a.nombre_tienda, fk_codigo_postal = _a.fk_codigo_postal, colonia = _a.colonia, direccion_tienda = _a.direccion_tienda, responsable_tienda = _a.responsable_tienda;
                // Validación básica
                if (!nombre_tienda || !fk_codigo_postal || !colonia || !direccion_tienda || !responsable_tienda) {
                    return [2 /*return*/, res.status(400).json({
                            ok: false,
                            mensaje: 'Faltan datos obligatorios en el cuerpo de la petición'
                        })];
                }
                query = "\n      INSERT INTO tiendas (\n        nombre_tienda,\n        fk_codigo_postal,\n        colonia,\n        direccion_tienda,\n        responsable_tienda\n      ) VALUES (?, ?, ?, ?, ?)\n    ";
                values = [
                    nombre_tienda,
                    fk_codigo_postal,
                    colonia,
                    direccion_tienda,
                    responsable_tienda
                ];
                return [4 /*yield*/, conexion.conexionLocal(query, values)];
            case 1:
                results = _b.sent();
                // Validar resultados y responder
                if (results && results.affectedRows > 0) {
                    res.status(201).json({
                        ok: true,
                        mensaje: 'Tienda creada exitosamente'
                    });
                }
                else {
                    res.status(500).json({
                        ok: false,
                        mensaje: 'Error al registrar la tienda'
                    });
                }
                return [3 /*break*/, 3];
            case 2:
                error_3 = _b.sent();
                console.error('Error al crear tienda:', error_3.message);
                res.status(500).json({
                    ok: false,
                    mensaje: 'Error interno del servidor',
                    error: error_3.message
                });
                return [3 /*break*/, 3];
            case 3: return [2 /*return*/];
        }
    });
}); };
exports.crearTiendaController = crearTiendaController;
/**
 * @function getdiassemana
 * @description Consulta los días de la semana asociados a una ruta específica.
 * @route GET /api/diassemana?id_ruta=123
 * @param {string} id_ruta - ID de la ruta a consultar (query param)
 * @returns Lista de días asociados a la ruta o error si no se encuentra
 */
var getdiassemana = function (req, res) { return __awaiter(void 0, void 0, void 0, function () {
    var id_ruta, fechaActual, semanaQuery, semanaResult, id_semana, results, error_4;
    return __generator(this, function (_a) {
        switch (_a.label) {
            case 0:
                _a.trys.push([0, 3, , 4]);
                id_ruta = req.query.id_ruta;
                // Validación básica
                if (!id_ruta) {
                    res.status(400).json({
                        ok: false,
                        mensaje: 'Parámetro id_ruta requerido'
                    });
                    return [2 /*return*/];
                }
                fechaActual = (0, moment_1.default)().format('YYYY-MM-DD');
                semanaQuery = "\n      SELECT id FROM semanas \n      WHERE ? BETWEEN inicio AND fin\n      LIMIT 1;\n    ";
                return [4 /*yield*/, conexion.conexionLocal(semanaQuery, [fechaActual])];
            case 1:
                semanaResult = _a.sent();
                if (!semanaResult || semanaResult.length === 0) {
                    res.status(404).json({
                        ok: false,
                        mensaje: 'No se encontró una semana activa para la fecha actual'
                    });
                    return [2 /*return*/];
                }
                id_semana = semanaResult[0].id;
                return [4 /*yield*/, conexion.conexionLocal('SELECT * FROM dias_semana WHERE ruta_id = ? AND semana_id = ?;', [id_ruta, id_semana])];
            case 2:
                results = _a.sent();
                if (results && results.length > 0) {
                    res.status(200).json({
                        ok: true,
                        id_semana: id_semana,
                        results: results
                    });
                }
                else {
                    res.status(404).json({
                        ok: false,
                        mensaje: 'No se encontraron días para la ruta especificada'
                    });
                }
                return [3 /*break*/, 4];
            case 3:
                error_4 = _a.sent();
                console.error('Error en getdiassemana:', error_4.message);
                res.status(500).json({
                    ok: false,
                    mensaje: 'Error interno del servidor',
                    error: error_4.message
                });
                return [3 /*break*/, 4];
            case 4: return [2 /*return*/];
        }
    });
}); };
exports.getdiassemana = getdiassemana;
