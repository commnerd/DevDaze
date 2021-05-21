import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from "@angular/forms";

import { HomeComponent } from '@pages/home/home.component';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { FormComponent as GroupFormComponent } from './partials/group/form/form.component';
import { CreateComponent as GroupCreateComponent } from '@pages/group/create/create.component';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    GroupFormComponent,
    GroupCreateComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
