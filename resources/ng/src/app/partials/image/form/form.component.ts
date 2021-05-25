import {Component, Input, OnInit} from '@angular/core';
import {Observable, of} from "rxjs";
import {Group} from "@interfaces/group.interface";
import {FormBuilder, FormGroup} from "@angular/forms";
import {Router} from "@angular/router";
import {HttpClient} from "@angular/common/http";
import {Image} from "@interfaces/image.interface";

@Component({
  selector: 'app-form',
  templateUrl: './form.component.html',
  styleUrls: ['./form.component.scss']
})
export class FormComponent implements OnInit {
  @Input() image$: Observable<Image> = of();

  imageForm: FormGroup = this.fb.group({
    name: [""],
    envs: [[{}]],
    ports: [[{}]],
    volumes: [[{}]]
  });

  constructor(
    private router: Router,
    private http: HttpClient,
    private fb: FormBuilder
  ) { }

  ngOnInit(): void {

  }

  submit() {
    if(this.imageForm.valid) {
      let subscription = this.http.post<Image>('/api/v1/image', this.imageForm.value)
        .subscribe(() => {
          subscription.unsubscribe();
          this.router.navigate(["/"]);
        })
    }
  }
}
