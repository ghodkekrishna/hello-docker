// src/app/services/auth.service.ts

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { Observable, of } from 'rxjs';
import { tap, map, catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  constructor(private http: HttpClient, private router: Router) {}

  login(email: string, password: string): Observable<boolean> {
    return this.http.post<any>('http://localhost:8081/api/login.php', { email, password }).pipe(
      map(response => {
        if (response.success) {
          localStorage.setItem('user', JSON.stringify(response.user)); // ✅ Store user info
          return true;
        } else {
          return false;
        }
      }),
      catchError(err => {
        return of(false);
      })
    );
  }

  logout(): void {
    localStorage.removeItem('user');
    this.router.navigate(['/']);
  }

  isLoggedIn(): boolean {
    return !!localStorage.getItem('user');
  }
}
