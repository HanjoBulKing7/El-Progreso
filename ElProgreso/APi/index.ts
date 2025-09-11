import Server from './classes/servidor';
import productosRuta from './routes/productos';
import usuarioRuta from './routes/usuario';
import express from 'express';
import cors from 'cors';
import ventasRutas from './routes/ventas';
import tiendasRutas from './routes/tiendasrutas';


const server = new Server();
server.app.use( express.static('public') );
server.app.use( cors())

server.app.use( express.json() )


server.app.use('/productos', productosRuta);
server.app.use('/usuario', usuarioRuta);
server.app.use('/ventas', ventasRutas);
server.app.use('/rutas', tiendasRutas)



server.start(() => {
    console.log('servidor corriendo');
})