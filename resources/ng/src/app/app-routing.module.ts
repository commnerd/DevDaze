import { RouterModule, Routes } from '@angular/router';
import { NgModule } from '@angular/core';

import { CreateComponent as GroupCreateComponent } from "@pages/group/create/create.component";
import { EditComponent as GroupEditComponent } from "@pages/group/edit/edit.component";
import { HomeComponent } from "@pages/home/home.component";


const routes: Routes = [
  { path: "", component: HomeComponent },
  { path: "group/create", component: GroupCreateComponent },
  { path: "group/:id/edit", component: GroupEditComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
