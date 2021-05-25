import { Component, OnInit } from '@angular/core';
import {Observable, of, Subscription} from "rxjs";
import { HttpClient } from '@angular/common/http';

import { Group } from "@interfaces/group.interface";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  constructor(private http: HttpClient) { }

  groups$: Observable<Array<Group>> = of();

  ngOnInit(): void {
    this.groups$ = this.http.get<Array<Group>>('/api/v1/group');
  }

  delete(id: number): void {
    let subscription: Subscription = this.http.delete<Group>(`/api/v1/group/${id}`)
      .subscribe((response) => {
        console.log(response);
        subscription.unsubscribe();
      });

    this.groups$ = this.http.get<Array<Group>>('/api/v1/group');
  }
}
