import { Router,Request,Response } from 'express';
import Usuario from '../classes/usuario';


const usuarioRuta = Router();

// val URLAutenticacion = "https://api.dazug.com.mx/usuario/obtenerusuario?"
usuarioRuta.get('/obtenerusuario', async (req: Request, res: Response) => {
    const email = req.query.email;
    const password = req.query.password
    
    const resultado = await Usuario.getUsuario(email, password);

    if (resultado){
        res.status(200).json({
            ok: true,
            mensaje: 'Usuario encontrado',
            resultado
        })
    }else{
        res.status(200).json({
            ok: true,
            mensaje: 'No se encontro Usuario',
            resultado
        })
    }
    
});

usuarioRuta.get('/verificartoken', async  (req: Request, res: Response) => {
    const token = req.header('x-token')
    const resultado = await Usuario.verifyToken(token)

    if(resultado){
        res.status(200).json({
            ok: true,
            resultado
        })
    }else{
        res.status(200).json({
            ok: false,
            token: "Incorrecto"
        })
    }
})



export default usuarioRuta;