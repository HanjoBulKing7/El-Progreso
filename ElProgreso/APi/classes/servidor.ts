import express from 'express';

export default class Server {

    public app : express.Application;
    public port: number = 3001;

    constructor() {
        this.app = express(); // inicializar el servicio de express 
    }

    start(callback: () => void) {
        this.app.listen(this.port, callback);
        //  https.createServer({
        //     key: fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/1a1ofertas_com.key'),
        //     cert: fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/1a1ofertas_com.crt'),
        //     ca: [
        //         fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/AAA_Certificate_Services.crt'),
        //         fs.readFileSync('/etc/apache2/certificados/1a1OFERTAS/USERTrust_RSA_Certification_Authority.crt')
        //     ]
        // },this.app).listen(this.port,callback);
    }


}