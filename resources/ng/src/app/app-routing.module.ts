import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { HomeComponent } from "@pages/home/home.component";
import { CreateComponent as GroupCreateComponent } from "@pages/group/create/create.component";


const routes: Routes = [
  { path: "", component: HomeComponent },
  { path: "group/create", component: GroupCreateComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
