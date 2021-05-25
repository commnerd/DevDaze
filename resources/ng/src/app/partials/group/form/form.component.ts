import {Component, Input, OnInit, OnDestroy} from '@angular/core';
import { Group } from "@interfaces/group.interface";
import { Image } from "@interfaces/image.interface";
import { FormGroup, FormBuilder } from "@angular/forms";
import { HttpClient } from "@angular/common/http";
import { Router, Params } from "@angular/router";
import {Observable, of, Subscription} from "rxjs";
import { mergeMap, tap, map } from "rxjs/operators";

@Component({
  selector: 'group-form',
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss']
})
export class FormComponent implements OnInit, OnDestroy {

  @Input() group$: Observable<Group> = of({title: "", fs_path: "", url: ""});
  private groupSubscription?: Subscription;

  groupForm: FormGroup = this.fb.group({
    title: [""],
    fs_path: [""],
    url: [""]
  });

  constructor(
    private router: Router,
    private http: HttpClient,
    private fb: FormBuilder
  ) { }

  ngOnInit(): void {
    this.groupSubscription = this.group$.subscribe((group: Group) => {
      this.groupForm.setValue({
        title: group.title,
        fs_path: group.fs_path,
        url: group.url
      });
    });
  }

  ngOnDestroy(): void {
    this.groupSubscription!.unsubscribe();
  }

  addImage() {
  }

  submit() {
    if(this.groupForm.valid) {
      let subscription = this.http.post<Group>('/api/v1/group', this.groupForm.value)
        .subscribe(() => {
          subscription.unsubscribe();
          this.router.navigate(["/"]);
        });
    }
  }
}
