
## FAQ (Scenario-Based Questions)

#### (Reporting and Communication): Imagine you're working on an urgent feature that has a deadline by the end of the week, but halfway through the task, you realize you're stuck on a critical issue that could delay the project. How would you handle this situation? How would you report the issue to your manager or team lead?

Before starting on task I will check all possible blocker and dependencies part of the requirement, once I understand the requirement I'll share my underdstanding to client and I'll make him aware about blocker and dependencies part.

So in future if I stuck on task I can easly convey the client this is blocker on which I'm stuck which I have made you aware.

#### (Loyalty and Commitment): You're offered a higher-paying job elsewhere, but you’ve recently joined this company and are currently working on an important feature. How would you approach this situation?

I wont accept further jobs untill my tenure is about to finish.
If I get job then its mendetory for me to complete the current company resigantion period.

#### (Handling Conflict in a Team): You’re working with a teammate who has a different approach to solving a technical problem. You believe your solution is better, but the other person insists on their approach. How do you resolve this conflict?

Its happen many time when I worked with low level developer, and I know very well how to deal in this scenario.

I'll show them broader prospective of the requirement which they dont see usaully they only focus on task complition. I'll sit with them and explain each approach to them and then ask which approch now will fit for this task. by considering all these they will opt the better approch only.

#### (Handling Criticism and Feedback): You’ve completed a project you’re proud of, but during the code review, your manager and team members point out several areas for improvement. How do you handle this feedback, and how would you improve the next time?

This happen very less but I would love it, By this I can understand more about my team knowledge and I can get the diffrent approaches for solutions and discussion will make code more bug free and resuanble 

##### (Teamwork and Collaboration): Your team is behind schedule on a project due to a lack of resources, and you notice your teammate is struggling with a task you’re familiar with. How would you help, and what steps would you take to ensure the project stays on track?

Sprint is already define and each task deadline is set by developer then its mendetory for them to make sure we achive it,
If not I can see who has less work I can align on it, and I'll also help him with my possible strenth so that as a team we achive our goal.

#### (Team Loyalty and Company Values): Can you give an example of a time when you demonstrated loyalty to your team or company, especially during a difficult or stressful situation?

In last project my teammate unable to share demo with client due to some server issue. I set with him 2 hours extra even after office hours. but that issue was not resolved, so told him to prepare demo video from local machine and share it with client and inform him about the server issue.

## FAQ (Infrastructure and Cloud Knowledge)

#### (Cloud Deployment): You are tasked with deploying an ERP system on AWS/Google Cloud. Describe the steps you would take to deploy the application and ensure it is scalable, secure, and cost-effective.

 - Deploy: Deploy steps are simple just need to push code and take pull and run needed commands (Those steps may vary based on configuration)
 - Scalable: For this code should be proper and server should be able to handle many requests that need to test and should have proper load balancer for this and server should be configured for scaling based on load
 - cost-effective: This mainly decided based on application load, we can define some policies on server to avoid high charges

#### (Database Backup and Redundancy): How would you ensure the ERP database is backed up, secure, and can be restored quickly in the event of data corruption or loss?

We can do multiple ways. 
- many server provides the db backed up and its security plus rollback options from the backed up history
- we can also write script to take backup and set new passowrd some intervally and we can also create script to put recent backed up copy on database.

#### (CI/CD Pipeline): Describe how you would set up a CI/CD pipeline to deploy updates to the ERP system while ensuring minimal downtime.

We can use GitHum actions and create a yaml files and define on which branch or event deploy should happen, this will reduce the mannul efforts plus make easy deployment process

#### (Security Best Practices): How would you secure the ERP system deployed on a cloud infrastructure like AWS or Google Cloud to protect sensitive data?

Ensure network security by using firewalls and private networks, enforce strict access controls with IAM and multi-factor authentication, and encrypt both data.



## FAQ (Problem-Solving and Creative Thinking)

#### You have a client in the manufacturing sector using your ERP system. Recently, they have been experiencing significant delays in their order fulfillment process due to inventory management issues and miscommunications between the production and procurement teams. They need a solution that optimizes their workflow, predicts inventory needs, and automatically generates reports for upper management.

Task:
- Suggest at least three ways you would enhance the ERP system to solve these problems, improve efficiency, and help the client achieve better order fulfillment.
- Propose any technical features, process optimizations, or integrations that could be implemented to solve these issues.


Solution:

- (Implementing an Inventory Management Module): Use real-time tracking and predictive analytics to forecast inventory needs and prevent shortages.
- (Integrating Workflow Automation): Automate task assignments and notifications between production and procurement teams to streamline communication and reduce delays.

- (Adding Reporting Tools): Create automated report generation for upper management to provide real-time insights into inventory levels and order status.

