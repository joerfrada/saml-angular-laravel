import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-demo',
  templateUrl: './demo.component.html',
  styleUrls: ['./demo.component.scss']
})
export class DemoComponent implements OnInit {

  currentUser: any;

  constructor() {
    this.currentUser = this.currentUser = JSON.parse(localStorage.getItem("currentUser") as any);
  }

  ngOnInit(): void {   
  }

  logout() {
    setTimeout(() => {
      localStorage.clear();
      location.href = 'https://www.dboralab.lan/apidemo/logout';
    }, 10);
  }

}
