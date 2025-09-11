"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
var express_1 = __importDefault(require("express"));
var Server = /** @class */ (function () {
    function Server() {
        this.port = 3001;
        this.app = (0, express_1.default)(); // inicializar el servicio de express 
    }
    Server.prototype.start = function (callback) {
        this.app.listen(this.port, callback);
        //  https.createServer({
        //     key: fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/1a1ofertas_com.key'),
        //     cert: fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/1a1ofertas_com.crt'),
        //     ca: [
        //         fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/AAA_Certificate_Services.crt'),
        //         fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/USERTrust_RSA_Certification_Authority.crt')
        //     ]
        // },this.app).listen(this.port,callback);
    };
    return Server;
}());
exports.default = Server;
