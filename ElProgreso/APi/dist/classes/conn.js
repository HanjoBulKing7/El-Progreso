"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
var dotenv_1 = __importDefault(require("dotenv"));
var mysql2_1 = __importDefault(require("mysql2"));
dotenv_1.default.config({ path: './.env' });
var Conexion = /** @class */ (function () {
    function Conexion() {
        this.poolLocal = mysql2_1.default.createPool({
            connectionLimit: 3,
            host: process.env.hostname,
            user: process.env.username,
            password: process.env.password,
            database: process.env.database
        });
    }
    Conexion.prototype.conexionLocal = function (queryExec, params) {
        var _this = this;
        if (params === void 0) { params = []; }
        return new Promise(function (resolve, reject) {
            _this.poolLocal.getConnection(function (err, connection) {
                if (err)
                    return reject(err); // error al obtener conexión
                connection.query(queryExec, params, function (error, results) {
                    connection.release(); // liberar la conexión al pool
                    if (error) {
                        return reject(error);
                    }
                    resolve(results);
                });
            });
        });
    };
    return Conexion;
}());
exports.default = Conexion;
