import { Component, OnInit } from '@angular/core';
import { HttpClient } from "@angular/common/http";

import { Group } from "@interfaces/group.interface";
import { Observable, of } from "rxjs";
import {ActivatedRoute, Params} from "@angular/router";
import { mergeMap } from "rxjs/operators";

@Component({
  selector: 'app-edit',
  templateUrl: './edit.component.html',
  styleUrls: ['./edit.component.scss']
})
export class EditComponent implements OnInit {

  group$: Observable<Group> = of();

  constructor(
    private route: ActivatedRoute,
    private http: HttpClient
  ) { }

  ngOnInit(): void {
    this.group$ = this.route.params.pipe(
      mergeMap<Params, Observable<Group>>((params: Params) => this.http.get<Group>(`/api/v1/group/${params.id}`))
    );
  }

}
