import jwt from 'jsonwebtoken';
import dotenv from "dotenv";

dotenv.config({path:'./.env'});

export default class Token{

    private static seed: string = 'process.env.seed';
    private static caducidad : string = '30d';

    constructor(){}

    static getJwtToken( payload: any): string {
        return jwt.sign({
            usuario: payload
        }, this.seed, { expiresIn: this.caducidad })
    }

    static comprobarToken( userToken: string){
        return new Promise( (resolve, reject ) => {
            jwt.verify(userToken, this.seed, (err,decode) => {
                err ? reject(false) : resolve(decode)
            })
        }); 
    }

}