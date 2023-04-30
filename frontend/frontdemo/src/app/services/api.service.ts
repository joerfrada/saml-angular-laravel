import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { retry, catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ApiService {

  private baseurl = "https://www.dboralab.lan/apidemo/api/";

  private apiLogin = this.baseurl + "login";

  constructor(private http: HttpClient) { }

  private getHttpOptions(tipo = 'l'): any {
    if (tipo == 'l') {
      return {
        headers: new HttpHeaders({
          'Content-Type': 'application/json;charset=utf8',
          'Data-Type': 'json'
        })
      };
    }
    else if (tipo == 'g') {
      return {
        headers: new HttpHeaders({
          'Content-Type': 'application/json',
          'Data-Type': 'json',
          'Accept': 'json'
        })
      };
    }
    else if (tipo == 'b') {
      return {
        headers: new HttpHeaders({
          'Content-Type': 'application/json;charset=utf8',
          'Data-Type': 'json'
        }),
        responseType: 'blob' as 'json'
      };
    }
  }

  /* Error Exceptions */
  private errorHandle(error: any) {
    let errorMessage = "";
    if (error.error instanceof ErrorEvent) {
      errorMessage = error.error.Message;
    }
    else {
      if (error.status === 401) {
        errorMessage = "Su sesión ha expirado. Intente conectarse nuevamente.";        
      }
      else {
        errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;        
      }
    }

    return throwError(errorMessage);
  }

  public login(data: any): Observable<any> {
    return this.http.post<any>(this.apiLogin, JSON.stringify(data), this.getHttpOptions())
    .pipe(retry(1), catchError(this.errorHandle));
  }
}
