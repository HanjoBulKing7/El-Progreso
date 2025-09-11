"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
var servidor_1 = __importDefault(require("./classes/servidor"));
var productos_1 = __importDefault(require("./routes/productos"));
var usuario_1 = __importDefault(require("./routes/usuario"));
var express_1 = __importDefault(require("express"));
var cors_1 = __importDefault(require("cors"));
var ventas_1 = __importDefault(require("./routes/ventas"));
var tiendasrutas_1 = __importDefault(require("./routes/tiendasrutas"));
var server = new servidor_1.default();
server.app.use(express_1.default.static('public'));
server.app.use((0, cors_1.default)());
server.app.use(express_1.default.json());
server.app.use('/productos', productos_1.default);
server.app.use('/usuario', usuario_1.default);
server.app.use('/ventas', ventas_1.default);
server.app.use('/rutas', tiendasrutas_1.default);
server.start(function () {
    console.log('servidor corriendo');
});
