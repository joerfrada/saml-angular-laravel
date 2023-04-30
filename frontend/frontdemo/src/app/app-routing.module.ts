import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SamlComponent } from './saml/saml.component';
import { DemoComponent } from './demo/demo.component';

const routes: Routes = [
  { path: 'saml', component: SamlComponent },
  { path: '',   redirectTo: '/saml', pathMatch: 'full' },
  { path: 'home', component: DemoComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
