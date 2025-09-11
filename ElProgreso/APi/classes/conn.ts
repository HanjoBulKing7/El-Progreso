import dotenv from "dotenv";
import  mysql from "mysql2";

dotenv.config({path:'./.env'});


export default class Conexion{
    constructor(){}

    private poolLocal = mysql.createPool({
        connectionLimit : 3,
        host     : process.env.hostname,
        user     : process.env.username,
        password : process.env.password,
        database : process.env.database
    })

    conexionLocal(queryExec: string, params: any[] = []) {
    return new Promise((resolve, reject) => {
        this.poolLocal.getConnection((err, connection) => {
            if (err) return reject(err); // error al obtener conexión

            connection.query(queryExec, params, (error, results) => {
                connection.release(); // liberar la conexión al pool

                if (error) {
                    return reject(error);
                }

                resolve(results);
            });
        });
    });
}
}