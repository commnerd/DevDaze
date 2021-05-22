import { Component, OnInit } from '@angular/core';
import { Group } from "@interfaces/group.interface";
import { FormGroup, FormBuilder } from "@angular/forms";
import {HttpClient} from "@angular/common/http";
import {Router} from "@angular/router";

@Component({
  selector: 'group-form',
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss']
})
export class FormComponent implements OnInit {

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
  }

  submit() {
    if(this.groupForm.valid) {
      let subscription = this.http.post<Group>('/api/v1/group', this.groupForm.value)
        .subscribe(() => {
          subscription.unsubscribe();
          this.router.navigate(["/"]);
        })
    }
  }
}
