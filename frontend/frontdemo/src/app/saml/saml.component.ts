import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ApiService } from '../services/api.service';

@Component({
  selector: 'app-saml',
  templateUrl: './saml.component.html',
  styleUrls: ['./saml.component.scss']
})
export class SamlComponent implements OnInit {

  constructor(private route: ActivatedRoute, private router: Router, private api: ApiService) {}

  ngOnInit(): void {
    let id: any = this.route.snapshot.queryParamMap.get('q');
    if (id == null) {
      window.location.href = "https://www.dboralab.lan/apidemo/saml";
    }
    else {
      this.api.login({ q: id}).subscribe(data => {
        let response: any = data;
        if (response.tipo == 0) {
          localStorage.setItem("currentUser", JSON.stringify(response.user.result));
          setTimeout(() => {
            this.router.navigate(['home']);
          }, 1000);
        }
      });
    }
  }

}
