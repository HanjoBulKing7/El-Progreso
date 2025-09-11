
import Conexion from "./conn";
import Token from "./token";
import bcrypt from "bcrypt";

export default class Usuario{
    constructor(){}

    private static conex = new Conexion()

    static getUsuario(usuario: string, password: string){
        
        return new Promise(async (resolve) => {

            const results: any = await this.conex.conexionLocal(`SELECT users.id,users.password,name, apepat, apemat,fktiporol, rutas.id AS id_ruta FROM users
            INNER JOIN rutas ON users.id = rutas.user_id
            Where email = '${usuario}' and estatus = 1 `)

            // cambio del prefijo de laravel php
            results[0].password = results[0].password.replace(/^\$2y(.+)$/i, '$2b$1');

            if (results &&  await bcrypt.compare(password, results[0].password)) {
                const token = Token.getJwtToken(results);
                resolve(token)
              } else {
                resolve(false)
              }
            
            // const token = Token.getJwtToken(results);
            // results.length > 0 ? resolve(token) : resolve(false)
        })
    }

    static verifyToken( token: string){
        return new Promise( (resolve, reject) => {
            const datos = Token.comprobarToken(token)
            datos ? resolve(datos) : reject(false)
        })
    }
}